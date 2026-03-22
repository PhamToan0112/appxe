<?php

namespace App\Admin\Services\Driver;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\DriverRateWeight\DriverRateWeightRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Repositories\Address\AddressRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use App\Admin\Traits\Setup;
use App\Api\V1\Support\UseLog;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\VerificationStatus;
use App\Enums\User\UserStatus;
use App\Enums\Vehicle\VehicleStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Mail\ApproveDriverMail;
use Illuminate\Support\Facades\Mail;

class DriverService implements DriverServiceInterface
{
    use Setup, Roles, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DriverRepositoryInterface $repository;

    protected AddressRepositoryInterface $addressRepository;

    protected OrderRepositoryInterface $orderRepository;

    protected UserRepositoryInterface $userRepository;

    protected VehicleRepositoryInterface $vehicleRepository;

    protected FileService $fileService;

    protected DriverRateWeightRepositoryInterface $rateWeightRepository;



    public function __construct(
        DriverRepositoryInterface $repository,
        AddressRepositoryInterface $addressRepository,
        OrderRepositoryInterface $orderRepository,
        FileService $fileService,
        VehicleRepositoryInterface $vehicleRepository,
        DriverRateWeightRepositoryInterface $rateWeightRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->repository = $repository;
        $this->addressRepository = $addressRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->fileService = $fileService;
        $this->vehicleRepository = $vehicleRepository;
        $this->rateWeightRepository = $rateWeightRepository;

    }

    public function store(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $dataUser = $data['user_info'];
            $dataUser['code'] = uniqid_real();
            $dataUser['password'] = bcrypt($data['password']);
            $user = $this->userRepository->create($dataUser);

            $roles = $this->getRoleDriver();
            $this->repository->assignRoles($user, [$roles]);
            $userId = $user->id;
            if (!isset($data['auto_accept'])) {
                $data['auto_accept'] = AutoAccept::Off;
            }
            $data['current_lat'] = $data['end_lat'];
            $data['current_lng'] = $data['end_lng'];
            $data['current_address'] = $data['end_address'];
            $data['user_id'] = $userId;
            $driver = $this->repository->create($data);
            $data['driver_id'] = $driver->id;
            $vehicle = $this->vehicleRepository->create($data);
            $this->vehicleRepository->update($vehicle->id, [
                'status' => VehicleStatus::Active
            ]);


            $dataAddress['user_id'] = $userId;
            $dataAddress['name'] = $data['name'];
            $dataAddress['address'] = $data['address'];
            $dataAddress['latitude'] = $data['lat'];
            $dataAddress['longitude'] = $data['lng'];
            $user = $this->addressRepository->create($dataAddress);

            DB::commit();

            return $driver;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process create driver CMS', $e);
            return false;

        }
    }

    public function update(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $dataUser = $data['user_info'];
            $dataUser['username'] = $dataUser['phone'];
            $dataUser['password'] = $data['password'];
            $dataUser['status'] = $data['status'];
            if (isset($data['password']) && $data['password']) {
                $dataUser['password'] = bcrypt($data['password']);
            } else {
                unset($dataUser['password']);
            }

            $this->userRepository->update($dataUser['id'], $dataUser);

            if (!array_key_exists('auto_accept', $data)) {
                $data['auto_accept'] = AutoAccept::Off->value;
            }
            $data['current_lat'] = $data['end_lat'];
            $data['current_lng'] = $data['end_lng'];
            $data['current_address'] = $data['end_address'];

            $driver = $this->repository->update($data['id'], $data);
            if ($data['is_verified'] == VerificationStatus::Verified->value) {
                $this->repository->assignRoles($driver->user, [$this->getRoleDriver()]);

            } else {
                $this->repository->assignRoles($driver->user, [$this->getRoleCustomer()]);
            }

            $weightRanges = $data['weightRange'] ?? [];
            foreach ($weightRanges as $weightRangeId => $weightRangeData) {
                $this->rateWeightRepository->updateOrCreate(
                    [
                        'driver_id' => $driver->id,
                        'shipping_weight_range_id' => $weightRangeId
                    ],
                    [
                        'price' => $weightRangeData['price']
                    ]
                );
            }

            DB::commit();

            return $driver;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process update driver CMS', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        $driver = $this->repository->findOrFail($id);
        $user = $driver->user;
        if ($user) {
            $user->update(['status' => UserStatus::Inactive]);
        }
        return true;
    }


    /**
     * @throws Exception
     */
    public function approve($id): bool
    {
        DB::beginTransaction();

        try {
            $driver = $this->repository->findOrFail($id);

            $roles = $this->getRoleDriver();

            $this->repository->assignRoles($driver->user, [$roles]);

            $this->repository->updateAttribute($id, 'is_verified', VerificationStatus::Verified);

            $this->sendMail([$driver->user->email]);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to approve driver', $e);
            return false;
        }
    }

    public function reject($id): bool
    {
        DB::beginTransaction();

        try {
            $driver = $this->repository->findOrFail($id);

            $roles = $this->getRoleCustomer();

            $this->repository->assignRoles($driver->user, [$roles]);

            $this->repository->updateAttribute($id, 'is_verified', VerificationStatus::Cancelled);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to approve driver', $e);
            return false;
        }
    }

    public function pendingDriverMultipleRecode(Request $request): bool
    {
        $this->data = $request->all();

        if ($this->data['action'] == VerificationStatus::Verified->value) {
            $email = [];
            foreach ($this->data['id'] as $value) {
                $driver = $this->repository->findOrFail($value);
                $roles = $this->getRoleDriver();
                $this->repository->assignRoles($driver->user, [$roles]);
                $this->repository->updateAttribute($value, 'is_verified', VerificationStatus::Verified->value);
                $email[] = $driver->user->email;
            }
            $this->sendMail($email);
            return true;
        } else if ($this->data['action'] == VerificationStatus::Cancelled->value) {
            foreach ($this->data['id'] as $value) {
                $driver = $this->repository->findOrFail($value);
                $roles = $this->getRoleCustomer();
                $this->repository->assignRoles($driver->user, [$roles]);
                $this->repository->updateAttribute($value, 'is_verified', VerificationStatus::Cancelled->value);
            }
            return true;
        } else {
            return false;
        }
    }

    public function actionDriverMultipleRecode(Request $request)
    {
        $this->data = $request->all();

        switch ($this->data['action']) {
            case UserStatus::PendingConfirmation->value:
                foreach ($this->data['id'] as $value) {
                    $userId = $this->repository->findOrFail($value)->user_id;
                    $this->userRepository->updateAttribute($userId, 'status', UserStatus::PendingConfirmation);
                }
                return true;
            case UserStatus::Lock->value:
                foreach ($this->data['id'] as $value) {
                    $userId = $this->repository->findOrFail($value)->user_id;
                    $this->userRepository->updateAttribute($userId, 'status', UserStatus::Lock);
                }
                return true;
            case UserStatus::Active->value:
                foreach ($this->data['id'] as $value) {
                    $userId = $this->repository->findOrFail($value)->user_id;
                    $this->userRepository->updateAttribute($userId, 'status', UserStatus::Active);
                }
                return true;
            case UserStatus::Inactive->value:
                foreach ($this->data['id'] as $value) {
                    $userId = $this->repository->findOrFail($value)->user_id;
                    $this->userRepository->updateAttribute($userId, 'status', UserStatus::Inactive);
                }
                return true;
            default:
                return false;
        }
    }

    protected function sendMail(array $email)
    {
        foreach ($email as $value) {
            Mail::to($value)->send(new ApproveDriverMail());
        }
    }
}

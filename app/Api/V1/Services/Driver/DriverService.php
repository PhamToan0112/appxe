<?php

namespace App\Api\V1\Services\Driver;

use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use App\Constants\ImageFields;
use App\Enums\Driver\VerificationStatus;
use App\Enums\Order\OrderType;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Throwable;


class DriverService implements DriverServiceInterface
{
    use Setup, Roles, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    private string $folderDriver = "images/drivers";

    protected DriverRepositoryInterface $repository;

    protected UserRepositoryInterface $userRepository;
    protected VehicleRepositoryInterface $vehicleRepository;

    protected FileService $fileService;

    protected DiscountRepositoryInterface $discountRepository;

    public function __construct(
        DriverRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        VehicleRepositoryInterface $vehicleRepository,
        FileService $fileService,
        DiscountRepositoryInterface $discountRepository
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->fileService = $fileService;
        $this->discountRepository = $discountRepository;
    }


    public function store(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $existingDriver = $this->repository->findByField("user_id", $userId);

            if ($existingDriver) {
                throw new BadRequestException('User is already registered as a driver');
            }
            $data = $this->fileService->uploadImages($this->folderDriver, $data, ImageFields::getDriverFields());

            $data['is_verified'] = VerificationStatus::Unverified;
            // update user
            $user = $this->userRepository->update($userId, $data);
            $data['user_id'] = $user->id;

            // create driver
            $driver = $this->repository->create($data);
            $data['driver_id'] = $driver->id;

            $roles = $this->getRoleDriver();
            //create role
            $this->userRepository->assignRoles($user, [$roles]);
            // create vehicle
            $this->vehicleRepository->create($data);

            DB::commit();
            return $driver;
        } catch (BadRequestException $e) {
            DB::rollback();
            $this->logError('User is already registered as a driver: ', $e);
            throw $e;
        } catch (Throwable $e) {
            DB::rollback();
            $this->logError('Failed to process register driver', $e);
            return false;
        }
    }

    public function update(Request $request): bool
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $driver = $this->getCurrentDriver();
            $data = $this->fileService->uploadImages(
                $this->folderDriver,
                $data,
                ImageFields::getDriverFields(),
                $driver,
                ['user' => ['avatar']]
            );
            $user = $this->getCurrentUser();
            if (isset($data['phone'])) {
                $data['username'] = $data['phone'];
            }
            $this->userRepository->update($user->id, $data);
            $this->repository->update($driver->id, $data);
            $this->vehicleRepository->update($driver->vehicle->id, $data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update driver', $e);
            return false;
        }
    }

    public function search($request)
    {
        $data = $request->validated();

        return $this->repository->search($data);
    }

    public function getDriver()
    {
        $driverId = $this->getCurrentDriverId();
        $driver = $this->repository->findOrFail($driverId);

        return $driver;
    }

    public function updateDriverConfigs(Request $request): bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $driverId = $this->getCurrentDriverId();

            $driver = $this->repository->findOrFail($driverId);

            $this->userRepository->updateAttribute($driver->user_id, 'active', $data['active']);
            $driver->update($data);
            $weightRanges = $data['weight_ranges'] ?? [];
            foreach ($weightRanges as $weightRange) {
                $driver->rateWeights()->updateOrCreate(
                    ['shipping_weight_range_id' => $weightRange['id']],
                    ['price' => $weightRange['price']]
                );
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update driver configs', $e);
            return false;
        }
    }

    public function getDriverInfo($request)
    {
        $data = $request->validated();
        $driverId = $data['driver_id'];

        $distance = $data['distance'] ?? null;
        $orderType = $data['order_type'] ?? null;

        $driver = $this->repository->findOrFail($driverId);

        $driver->discount = $this->discountRepository->getByDriverId($driverId);

        if ($distance && $orderType) {
            switch ($orderType) {
                case OrderType::C_RIDE->value:
                    $price = $distance * $driver->service_ride_price;
                    $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Motorcycle)->first();
                    break;
                case OrderType::C_CAR->value:
                    $price = $distance * $driver->service_car_price;

                    $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Car4)->first();
                    if (!$vehicle) {
                        $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Car7)->first();
                    }
                    break;
                case OrderType::C_Delivery->value:
                    $price = $distance * $driver->service_delivery_now_price;
                    $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Motorcycle)->first();
                    break;
                case OrderType::C_Multi->value;
                    $price = $distance * $driver->delivery_later_fee_per_stop;
                    $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Motorcycle)->first();
                    break;
                case OrderType::C_Intercity->value:
                    $price = $distance * $driver->service_intercity_price;
                    $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Car4)->first();
                    if (!$vehicle) {
                        $vehicle = $driver->vehicles->where('status', VehicleStatus::Active)->where('type', VehicleType::Car7)->first();
                    }
                    break;
                default:
                    $price = $driver->booking_price;
                    $vehicle = null;
            }

            $driver->booking_price = $price;
            $driver->vehicle_info = $vehicle;
        }

        return $driver;
    }
}
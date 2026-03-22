<?php

namespace App\Admin\Services\Discount;

use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Enums\Discount\DiscountOption;
use App\Enums\Discount\DiscountSource;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use App\Enums\Discount\SendNotifyStatus;
use App\Models\Discount;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DiscountService implements DiscountServiceInterface
{
    use UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DiscountRepositoryInterface $repository;
    protected NotificationServiceInterface $notificationService;
    protected DriverRepositoryInterface $driverRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        DiscountRepositoryInterface $repository,
        NotificationServiceInterface $notificationService,
        DriverRepositoryInterface $driverRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->repository = $repository;
        $this->notificationService = $notificationService;
        $this->driverRepository = $driverRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object|false
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $data['source'] = DiscountSource::Admin;
            $data['status'] = DiscountStatus::Draft;
            $data['code'] = uniqid_real(6);

            if (isset($data['type'])) {
                if ($data['type'] == DiscountType::Money->value) {
                    $data['percent_value'] = null;
                } elseif ($data['type'] == DiscountType::Percent->value) {
                    $data['discount_value'] = null;
                }
            }

            $discount = $this->repository->create(data: $data);
            $discountId = $discount->id;

            //driverIds
            $driverIds = [];
            if (isset($data['driver_option']) && $data['driver_option'] == DiscountOption::All->value) {
                $driverIds = $this->driverRepository->getActiveVerifiedDrivers()->pluck('id')->toArray();
            } elseif (isset($data['driver_option']) && $data['driver_option'] == DiscountOption::None->value) {
                $driverIds = [];
            } elseif (isset($data['driver_ids'])) {
                $driverIds = $data['driver_ids'];
            }

            if (!empty($driverIds)) {
                $this->repository->attachRelations($discountId, $driverIds, 'drivers');
            }

            //userIds
            $userIds = [];
            if (isset($data['user_option']) && $data['user_option'] == DiscountOption::All->value) {
                $userIds = $this->userRepository->getActiveVerifiedUsers()->pluck('id')->toArray();
            } elseif (isset($data['user_option']) && $data['user_option'] == DiscountOption::None->value) {
                $userIds = [];
            } elseif (isset($data['user_ids'])) {
                $userIds = $data['user_ids'];
            }

            if (!empty($userIds)) {
                $this->repository->attachRelations($discountId, $userIds, 'users');
            }

            DB::commit();
            return $discount;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Discount create failed', $e);
            return false;
        }
    }

    public function update(Request $request): ?object
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $discount = $this->updateDiscount($data);

            $updatedDriverIds = $this->updateDiscountEntities($discount, $data, 'drivers');
            $updatedUserIds = $this->updateDiscountEntities($discount, $data, 'users');

            if ($discount->status === DiscountStatus::Published) {
                $this->sendNotifications($discount, $updatedDriverIds, $updatedUserIds);
            }

            DB::commit();
            return $discount;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Discount update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    private function updateDiscount(array $data): object
    {
        if ($data['type'] == DiscountType::Money->value) {
            $data['percent_value'] = null;
        } elseif ($data['type'] == DiscountType::Percent->value) {
            $data['discount_value'] = null;
        }

        $discountId = $data['id'];
        return $this->repository->update($discountId, $data);
    }

    private function updateDiscountEntities(object $discount, array $data, string $type): array
    {
        $relation = $type === 'drivers' ? $discount->drivers() : $discount->users();
        $optionKey = $type === 'drivers' ? 'driver_option' : 'user_option';

        if (isset($data[$optionKey]) && $data[$optionKey] == DiscountOption::None->value) {
            $relation->detach();
            return [];
        }

        $updatedIds = $type === 'drivers' ? $this->getDriverIds($data) : $this->getUserIds($data);

        $pivotData = collect($updatedIds)->mapWithKeys(fn($id) => [
            $id => ['notified' => SendNotifyStatus::NotYet->value],
        ])->toArray();

        $relation->sync($pivotData);

        return $updatedIds;
    }

    private function sendNotifications(object $discount, array $driverIds, array $userIds): void
    {
        $notifyTitle = config('notifications.discount.title');
        $notifyBody = config('notifications.discount.message');

        // Gửi thông báo cho driver
        foreach ($driverIds as $driverId) {
            $driver = $this->driverRepository->find($driverId);
            $notifiedStatus = optional($discount->drivers()->where('driver_id', $driverId)->first())->pivot->notified ?? 0;

            if ($driver && $notifiedStatus == SendNotifyStatus::NotYet->value) {
                $this->notificationService->sendFirebaseNotificationToDriver($driver, $notifyTitle, $notifyBody);
                $discount->drivers()->updateExistingPivot($driverId, ['notified' => SendNotifyStatus::Sent->value]);
            }
        }

        // Gửi thông báo cho user
        foreach ($userIds as $userId) {
            $user = $this->userRepository->find($userId);
            $notifiedStatus = optional($discount->users()->where('user_id', $userId)->first())->pivot->notified ?? 0;

            if ($user && $notifiedStatus == SendNotifyStatus::NotYet->value) {
                $this->notificationService->sendFirebaseNotificationToUser($user, $notifyTitle, $notifyBody);
                $discount->users()->updateExistingPivot($userId, ['notified' => SendNotifyStatus::Sent->value]);
            }
        }
    }

    private function getDriverIds(array $data): array
    {
        if (isset($data['driver_option']) && $data['driver_option'] == DiscountOption::All->value) {
            return $this->driverRepository->getActiveVerifiedDrivers()->pluck('id')->toArray();
        }

        if (isset($data['driver_ids']) && is_array($data['driver_ids'])) {
            return array_filter($data['driver_ids'], fn($id) => !empty ($id) && is_numeric($id));
        }

        return [];
    }

    private function getUserIds(array $data): array
    {
        if (isset($data['user_option']) && $data['user_option'] == DiscountOption::All->value) {
            return $this->userRepository->getActiveVerifiedUsers()->pluck('id')->toArray();
        }

        if (isset($data['user_ids']) && is_array($data['user_ids'])) {
            return array_filter($data['user_ids'], fn($id) => !empty ($id) && is_numeric($id));
        }

        return [];
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        $discount = $this->repository->findOrFail($id);
        if ($discount) {
            $discount->update(['status' => DiscountStatus::Inactive]);
        }

        return true;
    }

    public function actionMultipleRecode(Request $request): bool
    {
        $this->data = $request->all();
        switch ($this->data['action']) {
            case 'published':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', DiscountStatus::Published);
                }
                return true;
            case 'inactive':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', DiscountStatus::Inactive);
                }
                return true;
            default:
                return false;
        }
    }
}

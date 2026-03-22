<?php

namespace App\Api\V1\Services\Order\CRideCar;

use App\Admin\Services\File\FileService;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Order\OrderStatus;
use App\Traits\NotifiesViaFirebase;
use App\Api\V1\Support\AuthSupport;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderCRideCarService implements OrderCRideCarServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog, NotifiesViaFirebase;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected OrderRepositoryInterface $repository;

    protected DriverRepositoryInterface $driverRepository;

    protected NotificationServiceInterface $notificationService;

    protected ShipmentRepositoryInterface $shipmentRepository;

    protected DiscountRepositoryInterface $discountRepository;

    protected FileService $fileService;


    public function __construct(
        OrderRepositoryInterface     $repository,
        ShipmentRepositoryInterface  $shipmentRepository,
        NotificationServiceInterface $notificationService,
        DiscountRepositoryInterface  $discountRepository,
        DriverRepositoryInterface    $driverRepository,
        FileService                  $fileService
    )
    {
        $this->repository = $repository;
        $this->shipmentRepository = $shipmentRepository;
        $this->fileService = $fileService;
        $this->notificationService = $notificationService;
        $this->discountRepository = $discountRepository;
        $this->driverRepository = $driverRepository;
    }


    public function createBookOrder(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['code'] = uniqid_real(8);
            $data['status'] = OrderStatus::Pending;
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $data['platform_fee'] = 0;
            $data['total'] = 0;
            $shipment = $this->shipmentRepository->create($data);
            $order = $this->repository->create($data);
            $order->shipments()->attach($shipment->id);
            DB::commit();
            return $order;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process book order: ', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $orderId = $data['id'];
            $driverId = $data['driver_id'] ?? null;
            $data['status'] = OrderStatus::PendingDriverConfirmation;
            $discountId = $data['discount_id'] ?? null;
            if (isset($discountId)) {
                $discount = $this->discountRepository->findOrFail($discountId);
                $data['discount_id'] = $discount->id;
            }
            $order = $this->repository->update($orderId, $data);
            if ($driverId) {
                $driver = $this->driverRepository->findOrFail($driverId);
                $this->notificationService->sendNotificationNewOrderToDriver($driver, $order);
            }
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to update order: ', $e);
            return false;
        }

    }

    public function driverSelectOrder(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $driverId = $this->getCurrentDriverId();
            $orderId = $data['id'];
            $order = $this->repository->findOrFail($orderId);
            if ($order->driver_id != null) {
                throw new BadRequestException("Đơn hàng này đã có tài xế");
            }
            $order = $this->repository->update($orderId,
                [
                    'driver_id' => $driverId,
                    'status'=> OrderStatus::PendingDriverConfirmation
                ]);
            $this->notificationService->sendDriverWantsToTakeOrderNotification($order->user, $order);
            DB::commit();
            return $order;

        } catch (BadRequestException $e) {
            DB::rollback();
            throw $e;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to update driver select order: ', $e);
            return false;
        }
    }
}

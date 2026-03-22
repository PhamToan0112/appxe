<?php

namespace App\Api\V1\Services\Order\CIntercity;

use App\Admin\Services\File\FileService;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Traits\NotifiesViaFirebase;
use App\Api\V1\Support\AuthSupport;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderCIntercityService implements OrderCInterCityServiceInterface
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


    public function createCIntercityOrder(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['user_id'] = $this->getCurrentUserId();
            $data['code'] = uniqid_real(8);
            $data['status'] = OrderStatus::PendingDriverConfirmation;
            $data['order_type'] = OrderType::C_Intercity;
            $shipment = $this->shipmentRepository->create($data);
            $order = $this->repository->create($data);
            $this->notificationService->sendNotificationNewOrderToDriver($order->driver, $order);
            $order->shipments()->attach($shipment->id);
            DB::commit();
            return $order;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process book order: ', $e);
            return false;
        }
    }
}

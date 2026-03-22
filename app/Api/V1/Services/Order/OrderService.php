<?php

namespace App\Api\V1\Services\Order;

use App\Admin\Repositories\RecentLocation\RecentLocationRepositoryInterface;
use App\Admin\Services\Calculation\CalculationServiceInterface;
use App\Admin\Services\File\FileService;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Services\Wallet\WalletServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use App\Models\Order;
use App\Traits\NotifiesViaFirebase;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use App\Enums\DefaultStatus;
use App\Traits\UseLog;

class OrderService implements OrderServiceInterface
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

    protected DiscountRepositoryInterface $discountRepository;
    protected RecentLocationRepositoryInterface $recentLocationRepository;
    protected WalletServiceInterface $walletService;

    protected ShipmentRepositoryInterface $shipmentRepository;

    protected CalculationServiceInterface $calculationService;

    protected FileService $fileService;


    public function __construct(
        OrderRepositoryInterface          $repository,
        DriverRepositoryInterface         $driverRepository,
        DiscountRepositoryInterface       $discountRepository,
        NotificationServiceInterface      $notificationService,
        RecentLocationRepositoryInterface $recentLocationRepository,
        WalletServiceInterface            $walletService,
        ShipmentRepositoryInterface       $shipmentRepository,
        FileService                       $fileService,
        CalculationServiceInterface       $calculationService
    )
    {
        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
        $this->discountRepository = $discountRepository;
        $this->notificationService = $notificationService;
        $this->recentLocationRepository = $recentLocationRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->walletService = $walletService;
        $this->fileService = $fileService;
        $this->calculationService = $calculationService;
    }

    public function checkCreateOrder(Request $request): bool
    {
        $data = $request->validated();
        $userId = $this->getCurrentUserId();

        $exclusiveTypes = [
            OrderType::C_RIDE->value,
            OrderType::C_CAR->value,
            OrderType::C_Delivery->value,
        ];

        if (in_array($data['order_type'], $exclusiveTypes)) {
            $ordersWithNullDrivers = $this->repository->getBy([
                'user_id' => $userId,
                'driver_id' => null,
                ['order_type', 'IN', $exclusiveTypes]
            ]);

            $activeOrders = $this->repository->getBy([
                'user_id' => $userId,
                ['order_type', 'IN', $exclusiveTypes],
                ['status', 'NOT_IN', [
                    OrderStatus::Cancelled,
                    OrderStatus::CustomerCanceled,
                    OrderStatus::DriverCanceled,
                    OrderStatus::Completed,
                    OrderStatus::Returned
                ]]
            ]);

            $combinedOrders = $ordersWithNullDrivers->merge($activeOrders)->unique('id');

            if ($combinedOrders->isNotEmpty()) {
                throw new BadRequestException("You cannot create a new order of type " . $data['order_type'] . " since there are conflicting conditions met with existing orders.");
            }
        }

        return true;
    }


    /**
     * @throws Exception
     */
    public function getOrderActive(Request $request)
    {
        $data = $request->validated();

        $driverId = $this->getCurrentDriverId() ?? null;
        $userId = $this->getCurrentUserId();
        $query = [
            ['status', 'NOT_IN', [
                OrderStatus::Cancelled,
                OrderStatus::CustomerCanceled,
                OrderStatus::DriverCanceled,
                OrderStatus::Completed,
                OrderStatus::Returned,
                OrderStatus::Pending,
                OrderStatus::Draft,
                OrderStatus::Preparing,

            ]],
            ['order_type', 'IN', [
                OrderType::C_RIDE,
                OrderType::C_CAR,
                OrderType::C_Delivery,
                OrderType::C_Multi
            ]],
        ];

        if ($driverId) {
            $query['driver_id'] = $driverId;
        } else {
            $query['user_id'] = $userId;
        }

        return $this->repository->getBy($query);
    }

    /**
     * @throws Exception
     */
    public function getOrdersWithoutDriver(Request $request)
    {
        $data = $request->validated();
        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;

        $query = $this->repository->getByQueryBuilder([
            'driver_id' => null,
            ['is_deleted', '!=', DefaultStatus::Deleted],
            ['status', '!=', OrderStatus::CustomerCanceled]
        ]);

        if (isset($data['order_type'])) {
            $query->where('order_type', $data['order_type']);
        }

        $orders = $query->paginate($limit, ['*'], 'page', $page);

        return $orders;
    }


    public function reportOrderIssues($request): bool|array
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $returnImage = $data['return_image'];
            $order = $this->repository->findOrFail($data['order_id']);
            if (!$order) {
                throw new Exception("Order not found");
            }

            if ($returnImage) {
                $returnImage = $this->fileService
                    ->uploadAvatar('images/orders', $returnImage, $order->returnImage);
            }
            $order->return_image = $returnImage;
            $order->status = OrderStatus::Returned;
            $order->save();

            $issues = $this->repository->createOrderIssue($data['reports'], $order->id);

            DB::commit();

            return $issues;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Report order issues failed", $e);
            return false;
        }
    }

    public function handlePaymentWallet($paymentMethod, $amount, $userId): void
    {
        if ($paymentMethod == PaymentMethod::Wallet->value) {
            $this->walletService->deductAmount($amount, $userId);
        }

    }


    /**
     * @throws Exception
     */
    public function delete($id): object
    {
        return $this->repository->update($id, ['is_deleted' => DefaultStatus::Deleted]);
    }


    public function updateStatus(Request $request): bool
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $status = $data['status'];
            $reasonCancel = $data['reason_cancel'] ?? null;
            $order = $this->repository->findByField("code", $data['code']);

            if (!$order) {
                throw new Exception("Order not found");
            }

            switch ($status) {
                /** Tài xế đã xác nhận */
                case OrderStatus::DriverConfirmed->value:
                    $this->handleDriverConfirmed($order);
                    break;
                /** Tài xế đã từ chối đơn hàng */
                case OrderStatus::DriverDeclined->value:
                    $this->handleDriverDeclined($order);
                    break;
                /** Khách hàng đã từ chối đơn hàng */
                case OrderStatus::CustomerDeclined->value:
                    $this->handleCustomerDeclined($order);
                    break;
                /** khách hàng đã xác nhận */
                case OrderStatus::CustomerConfirmed->value:
                    $this->handleCustomerConfirm($order);
                    break;
                /** Đơn hàng đang trong quá trình di chuyển */
                case OrderStatus::InTransit->value:
                    $this->handleInTransit($order);
                    break;
                /** Đang đến lấy hàng */
                case OrderStatus::PickingUp->value:
                    if ($order->order_type == OrderType::C_Delivery) {
                        $this->handlePickUp($order);
                    }
                    break;
                /** Tài xế đã hủy đơn hàng */
                case OrderStatus::DriverCanceled->value:
                    $this->handleDriverCanceled($order, $reasonCancel);
                    break;
                /** Khách hàng đã hủy đơn hàng */
                case OrderStatus::CustomerCanceled->value:
                    $this->handleCustomerCanceled($order, $reasonCancel);
                    break;
                /** Đơn hàng đã hoàn thành */
                case OrderStatus::Completed->value:
                    $this->handleCompleted($order);
                    break;
                default:
                    throw new Exception("Invalid status provided");
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Update status failed", $e);
            return false;
        }
    }


    protected function handleDriverConfirmed($order): void
    {
        $this->handleStatusChange($order, OrderStatus::DriverConfirmed);
        $this->notificationService->sendDriverConfirmedNotification($order->user, $order);

    }

    protected function handlePickUp($order): void
    {
        $this->handleStatusChange($order, OrderStatus::PickingUp);
        $this->notificationService->sendDriverOnWayToPickUpNotification($order->user, $order);
    }

    protected function handleInTransit($order): void
    {
        $this->handleStatusChange($order, OrderStatus::InTransit);
        $this->notificationService->sendDriverOnTheMoveNotification($order->user, $order);

    }

    /**
     * @throws Exception
     */
    protected function handleCustomerConfirm($order): void
    {
        $orderType = $order->order_type->value;
        $driver = $order->driver;
        if ($orderType == OrderType::C_RIDE->value || $orderType == OrderType::C_CAR->value) {
            $this->updateOrderRideCar($order, $driver);
        }


        $this->notificationService->sendCustomerAcceptedOrderNotification($order->user, $order);

    }

    /**
     * @throws Exception
     */
    private function updateOrderRideCar($order, $driver): void
    {
        $orderType = $order->order_type->value;
        $shipment = $order->shipments->first();
        $distance = $shipment->distance ?? null;
        $subTotal = $this->calculationService->calculateSubTotal($distance, $driver, $orderType, []);
        $peakHourFee = $this->calculationService->calculatePeakHourFeeCRideCar($driver, $orderType);
        $platformFee = $this->calculationService->calculatePlatformFeeCRideCar($subTotal, $distance, $orderType);
        $HolidayPrice = $this->calculationService->calculateHolidayFee($driver);
        $peakAreaFee = $this->calculationService->calculateAreaFee($shipment->end_latitude, $shipment->end_longitude, $driver);
        $total = $this->calculationService->calculateTotal($subTotal, $platformFee, 0, $peakAreaFee,
            $HolidayPrice, $peakHourFee);
        $data = [
            'sub_total' => $subTotal,
            'peak_hour_fee' => $peakHourFee,
            'platform_fee' => $platformFee,
            'holiday_price' => $HolidayPrice,
            'peak_area_fee' => $peakAreaFee,
            'total' => $total,
            'status' => OrderStatus::DriverConfirmed
        ];
        $order->update($data);
    }

    protected function handleCustomerDeclined($order): void
    {
        $this->handleStatusChange($order, OrderStatus::Pending);
        $this->notificationService->sendCustomerDeclinedDriverNotification($order->driver, $order);
        $order->update(['driver_id' => null]);
    }

    protected function handleDriverDeclined($order): void
    {
        $this->handleStatusChange($order, OrderStatus::DriverDeclined);
        $this->notificationService->sendCustomerDriverDeclinedNotification($order->driver->user, $order);
        $order->update(['driver_id' => null]);
    }

    protected function handleDriverCanceled($order, $reasonCancel): void
    {
        $this->handleStatusChange($order, OrderStatus::DriverCanceled);
        $this->notificationService->sendCustomerCanceledNotification($order->user, $order);
        $order->update(['reason_cancel' => $reasonCancel]);
    }

    protected function handleCustomerCanceled($order, $reasonCancel): void
    {
        $this->handleStatusChange($order, OrderStatus::CustomerCanceled);

        $this->notificationService->sendDriverCanceledNotification($order->driver->user, $order);
        $order->update(['reason_cancel' => $reasonCancel]);
    }


    /**
     * @throws Exception
     */
    protected function handleCompleted($order): void
    {
        $this->handleStatusChange($order, OrderStatus::Completed);

        switch ($order->order_type) {
            case OrderType::C_RIDE:
            case OrderType::C_CAR:
                $this->calculateOrderCRideCar($order);
                break;

            case OrderType::C_Delivery:
                $this->calculateOrderDelivery($order);
                break;
            default:
                break;
        }
        $this->notificationService->completedOrder($order->user, $order);

        $this->saveRecentLocation($order);
    }

    /**
     * Tính toán và trừ các khoản phí từ đơn hàng.
     * @param Order $order Đơn hàng cần xử lý
     *
     * @return void Không có giá trị trả về
     *
     * @throws Exception
     */
    private function calculateOrderCRideCar(Order $order): void
    {
        $platformFee = $order->platform_fee;

        if ($order->payment_method == PaymentMethod::Wallet) {
            $total = $order->total - $platformFee;
            $this->walletService->deductAmount($order->total, $order->user_id);
            $this->walletService->addFunds($total, $order->driver->user->id, $order);

        } else {
            $total = $order->total - (2 * $platformFee);
            $this->walletService->addFunds($total, $order->driver->user->id, $order);
        }

    }

    /**
     * Tính toán và xử lý các giao dịch thanh toán cho đơn hàng giao hàng.
     *
     * @param Order $order Đơn hàng cần xử lý
     * @return void Không có giá trị trả về
     */
    private function calculateOrderDelivery(Order $order): void
    {
        $platformFee = $order->platform_fee;

        switch ($order->payment_role) {
            case PaymentRole::SENDER:
                switch ($order->payment_method) {
                    case PaymentMethod::Wallet:
                        $this->walletService->deductAmount($order->total, $order->user_id);
                        $total = $order->total - $platformFee;
                        $this->walletService->addFunds($total, $order->driver->user->id, $order);
                        break;
                    case PaymentMethod::Direct:
                        $total = $order->total - (2 * $platformFee);
                        $this->walletService->addFunds($total, $order->driver->user->id, $order);
                        break;
                }
                break;
            case PaymentRole::RECIPIENT:
                $total = $order->total - (2 * $platformFee);
                $this->walletService->addFunds($total, $order->driver->user->id, $order);
                break;
        }
    }


    /**
     * @throws Exception
     */
    protected function saveRecentLocation($order): void
    {
        $attributes = [
            'user_id' => $order->user->id,
            'start_address' => $order->start_address,
            'end_address' => $order->end_address,
        ];

        $values = [
            'start_latitude' => $order->start_latitude,
            'start_longitude' => $order->start_longitude,
            'end_latitude' => $order->end_latitude,
            'end_longitude' => $order->end_longitude,
            'type' => $order->order_type,
        ];

        $this->recentLocationRepository->updateOrCreate($attributes, $values);
    }


    protected function handleStatusChange($order, $newStatus): void
    {
        $this->repository->updateAttribute($order->id, 'status', $newStatus);
    }


    public function assignDriverToOrder(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $order = $this->repository->findByField('code', $data['code']);
            $order->update([
                'driver_id' => $data['driver_id'],
                'status' => OrderStatus::PendingDriverConfirmation
            ]);
            $this->notificationService->sendNotificationNewOrderToDriver($order->driver, $order);

            Db::commit();
            return $order;
        } catch (Exception $e) {
            $this->logError("Assign driver to order failed", $e);
            DB::rollback();
            return false;
        }
    }

    public function selectCustomerForOrder(Request $request): Model|bool|null
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $order = $this->repository->findByField('code', $data['code']);
            $order->update([
                'driver_id' => $data['driver_id'],
                'status' => OrderStatus::PendingCustomerConfirmation
            ]);
            $this->notificationService->sendDriverSelectedCustomerNotification($order->user, $order);

            Db::commit();
            return $order;
        } catch (Exception $e) {
            $this->logError("Assign driver to order failed", $e);
            DB::rollback();
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function uploadOrderConfirmationImage(Request $request): object
    {
        $data = $request->validated();
        $order = $this->repository->findOrFail($data['id']);
        $orderConfirmationImage = $data['order_confirmation_image'];
        if ($orderConfirmationImage) {
            $data['order_confirmation_image'] = $this->fileService
                ->uploadAvatar('images/orders', $orderConfirmationImage, $order->order_confirmation_image);
        }
        return $this->repository->update($order->id, $data);
    }

    /**
     * @throws Exception
     */
    public function getOrderByUser(Request $request)
    {
        $data = $request->validated();
        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;
        $currentUserId = $this->getCurrentUserId();
        $driverId = $this->getCurrentDriverId();
        $orderType = $data['order_type'] ?? null;
        $status = $data['status'] ?? null;

        $query = $this->repository->getByQueryBuilder([
            ['is_deleted', '!=', DefaultStatus::Deleted]
        ]);

        $query->where(function ($query) use ($currentUserId, $driverId) {
            if ($driverId) {
                $query->where('driver_id', $driverId);
            } else {
                $query->where('user_id', $currentUserId);
            }
        });

        $query->when($orderType, function ($query) use ($orderType) {
            $query->where('order_type', $orderType);
        });

        $query->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        });

        return $query->paginate($limit, ['*'], 'page', $page);
    }


    /**
     * @throws Exception
     */
    public function updateLocation(Request $request): object
    {
        $data = $request->validated();
        return $this->repository->update($data['id'], $data);
    }


}

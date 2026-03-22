<?php

namespace App\Api\V1\Services\Order\CDelivery;

use App\Admin\Services\File\FileService;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Services\Wallet\WalletServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\OpenStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Traits\NotifiesViaFirebase;
use App\Api\V1\Support\AuthSupport;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderCDeliveryService implements OrderCDeliveryServiceInterface
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

    protected ShipmentRepositoryInterface $shipmentRepository;

    protected NotificationServiceInterface $notificationService;

    protected WalletServiceInterface $walletService;

    protected FileService $fileService;


    public function __construct(
        OrderRepositoryInterface     $repository,
        ShipmentRepositoryInterface  $shipmentRepository,
        DriverRepositoryInterface    $driverRepository,
        NotificationServiceInterface $notificationService,
        WalletServiceInterface       $walletService,
        FileService                  $fileService
    )
    {
        $this->repository = $repository;
        $this->shipmentRepository = $shipmentRepository;
        $this->fileService = $fileService;
        $this->driverRepository = $driverRepository;
        $this->notificationService = $notificationService;
        $this->walletService = $walletService;
    }

    public function createDeliveryOrder(Request $request): object|bool
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $data['code'] = uniqid_real(8);
            $data['order_type'] = OrderType::C_Delivery;
            $data['status'] = OrderStatus::PendingDriverConfirmation;

            $shipment = $this->shipmentRepository->create($data);
            if ($request->filled('category_ids')) {
                $shipment->categories()->attach($request->category_ids);
            }
            $order = $this->repository->create($data);
            $order->shipments()->attach($shipment->id);

            $this->handleMoneyHanging($order);

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to create delivery order:', $e);
            return false;
        }
    }

    private function handleMoneyHanging($order): void
    {
        if ($order->advance_payment_status == OpenStatus::ON && $order->payment_role == PaymentRole::RECIPIENT) {
            $this->walletService->deductAmountSilently($order->advance_payment_amount, $order->user->id);
            $this->notificationService->sendOrderHoldNotification($order->user, $order);
        }

    }

}

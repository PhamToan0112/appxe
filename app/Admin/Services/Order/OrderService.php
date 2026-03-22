<?php

namespace App\Admin\Services\Order;

use App\Admin\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\OrderCIntercityStatus;
use App\Enums\Order\OrderCMultiStatus;
use App\Enums\Order\OrderCRideCarStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin\Repositories\Order\{OrderRepositoryInterface};
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;


class OrderService implements OrderServiceInterface
{
    use UseLog;

    protected array $data;

    protected OrderRepositoryInterface $repository;

    protected UserRepositoryInterface $userRepository;
    protected VehicleRepositoryInterface $vehicleRepository;

    protected ShipmentRepositoryInterface $shipmentRepository;

    protected NotificationServiceInterface $notificationService;

    public function __construct(
        OrderRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        VehicleRepositoryInterface $vehicleRepository,
        ShipmentRepositoryInterface $shipmentRepository,
        NotificationServiceInterface $notificationService
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->notificationService = $notificationService;
    }


    public function updateCRideCar(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $data['start_latitude'] = $data['lat'];
            $data['start_longitude'] = $data['lng'];
            $data['start_address'] = $data['address'];
            $data['end_latitude'] = $data['end_lat'];
            $data['end_longitude'] = $data['end_lng'];
            $order = $this->repository->update($data['id'], $data);
            $shipment = $order->shipments->first();
            $this->shipmentRepository->update($shipment['id'], $data);

            $this->sendNotification($order);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Update C Ride Car failed", $e);
            return false;
        }
    }

    public function updateCDelivery(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $data['start_latitude'] = $data['lat'];
            $data['start_longitude'] = $data['lng'];
            $data['start_address'] = $data['address'];
            $data['end_latitude'] = $data['end_lat'];
            $data['end_longitude'] = $data['end_lng'];

            $categories = $data['categories'] ?? [];

            $order = $this->repository->update($data['id'], $data);
            $shipment = $order->shipments->first();
            $shipment->categories()->sync($categories);

            $shipment->sender_name = $data['sender_name'];
            $shipment->sender_phone = $data['sender_phone'];
            $shipment->save();

            $this->shipmentRepository->update($shipment['id'], $data);
            $this->sendNotification($order);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Update C-Delivery failed", $e);
            return false;
        }
    }

    public function updateCMulti(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $order = $this->repository->update($data['id'], $data);
            $this->sendNotification($order);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Update C Multi  failed", $e);
            return false;
        }
    }

    public function updateCIntercity(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['start_latitude'] = $data['lat'];
            $data['start_longitude'] = $data['lng'];
            $data['start_address'] = $data['address'];
            $data['end_latitude'] = $data['end_lat'];
            $data['end_longitude'] = $data['end_lng'];
            $order = $this->repository->update($data['id'], $data);
            $shipment = $order->shipments->first();
            $this->shipmentRepository->update($shipment['id'], $data);
            $this->sendNotification($order);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Update C Ride Car failed", $e);
            return false;
        }
    }

    protected function sendNotification($order): void
    {
        $orderType = $order->order_type->value;
        $status = $order->status->value;

        switch ($status) {
            //Chờ tài xác nhận -> gửi thông báo cho khách
            case OrderCRideCarStatus::PendingDriverConfirmation->value:
            case OrderCDeliveryStatus::PendingDriverConfirmation->value:
            case OrderCIntercityStatus::PendingDriverConfirmation->value:
                $this->notificationService->pendingDriverConfirmation($order);
                break;

            //Chờ khách xác nhận -> gửi thông báo cho tài
            case OrderCRideCarStatus::PendingCustomerConfirmation->value:
            case OrderCDeliveryStatus::PendingCustomerConfirmation->value:
                $this->notificationService->pendingUserConfirmation($order);
                break;

            //Tài đã nhận -> gửi thông báo cho khách
            case OrderCRideCarStatus::DriverConfirmed->value:
            case OrderCDeliveryStatus::DriverConfirmed->value:
            case OrderCIntercityStatus::DriverConfirmed->value:
                $this->notificationService->driverConfirmedOrder($order);
                break;

            //Khách đã nhận -> gửi thông báo cho tài
            case OrderCRideCarStatus::CustomerConfirmed->value:
            case OrderCDeliveryStatus::CustomerConfirmed->value:
                $this->notificationService->userConfirmedOrder($order);
                break;

            //Tài từ chối -> gửi thông báo cho khách
            case OrderCRideCarStatus::DriverDeclined->value:
            case OrderCDeliveryStatus::DriverDeclined->value:
            case OrderCIntercityStatus::DriverDeclined->value:
                $this->notificationService->driverDeclinedOrder($order);
                break;

            //Khách từ chối -> gửi thông báo cho tài
            case OrderCRideCarStatus::CustomerDeclined->value:
            case OrderCDeliveryStatus::CustomerDeclined->value:
                $this->notificationService->userDeclinedOrder($order);
                break;

            //Đang di chuyển -> gửi thông báo cho cả 2
            case OrderCRideCarStatus::InTransit->value:
            case OrderCDeliveryStatus::InTransit->value:
                $this->notificationService->inTransitOrder($order);
                break;

            //Hoàn thành -> gửi thông báo cho cả 2
            case OrderCRideCarStatus::Completed->value:
            case OrderCDeliveryStatus::Completed->value:
            case OrderCIntercityStatus::Completed->value:
                $this->notificationService->completedOrder($order);
                break;

            //Tài hủy -> gửi thông báo cho khách
            case OrderCRideCarStatus::DriverCanceled->value:
            case OrderCDeliveryStatus::DriverCanceled->value:
            case OrderCIntercityStatus::DriverCanceled->value:
            case OrderCMultiStatus::DriverCanceled->value:
                $this->notificationService->driverCancelledOrder($order);
                break;

            //Khách hủy -> gửi thông báo cho tài
            case OrderCRideCarStatus::CustomerCanceled->value:
            case OrderCDeliveryStatus::CustomerCanceled->value:
            case OrderCIntercityStatus::CustomerCanceled->value:
            case OrderCMultiStatus::CustomerCanceled->value:
                $this->notificationService->userCancelledOrder($order);
                break;

            //Delivery -> Tài đang đến lấy hàng -> gửi thông báo cho khách:
            case OrderCDeliveryStatus::PickingUp->value:
                if ($orderType == OrderType::C_Delivery->value)
                    $this->notificationService->driverOnWayToPickUp($order);
                break;
            //Delivery -> Trả hàng -> gửi thông báo cho người gửi:
            case OrderCDeliveryStatus::Returned->value:
                if ($orderType == OrderType::C_Delivery->value)
                    $this->notificationService->returnedOrder($order);
                break;
            default:
                break;
        }
    }
}

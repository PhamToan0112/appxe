<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderStatus: string
{
    use Enum;

    // Đơn hàng đang chờ xác nhận
    case Pending = "pending";

    // Chờ tài xế xác nhận
    case PendingDriverConfirmation = "pending_driver_confirmation";

    // Chờ khách hàng xác nhận
    case PendingCustomerConfirmation = "pending_customer_confirmation";

    // Đơn hàng đã được xác nhận
    case Confirmed = "confirmed";

    // Tài xế đã xác nhận
    case DriverConfirmed = "driver_confirmed";

    // khách hàng đã xác nhận
    case CustomerConfirmed = "customer_confirmed";

    // Tài xế đã từ chối đơn hàng
    case DriverDeclined = "driver_declined";

    // Khách hàng đã từ chối đơn hàng
    case CustomerDeclined = "customer_declined";

    // Đang đến lấy hàng
    case PickingUp = "picking_up";
    // Đơn hàng đang trong quá trình di chuyển
    case InTransit = "in_transit";
    // Đã đến cửa hàng
    case ArrivedAtStore = "arrived_at_store";
    // Đang di chuyển đến điểm đến
    case MovingToDestination = "moving_to_destination";
    // Đơn hàng đã hoàn thành
    case Completed = "completed";
    // Đơn hàng đã bị hủy
    case Cancelled = "cancelled";
    // Đơn hàng không thành công
    case Failed = "failed";

    // Đơn hàng đang chuẩn bị
    case Preparing = "preparing";

    // Đơn hàng bản nháp
    case Draft = "draft";

    // Đã trả hàng
    case Canceled = "canceled";

    // Đã trả hàng
    case Returned = "returned";


    // Tài xế đã hủy đơn hàng
    case DriverCanceled = "driver_canceled";

    // Khách hàng đã hủy đơn hàng
    case CustomerCanceled = "customer_canceled";

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-lt',
            self::PendingDriverConfirmation, self::PendingCustomerConfirmation => 'bg-light-yellow',
            self::Confirmed => 'bg-blue-lt',
            self::DriverConfirmed, self::CustomerConfirmed => 'bg-light-blue',
            self::PickingUp => 'bg-pink-lt',
            self::InTransit, self::Returned => 'bg-purple-lt',
            self::ArrivedAtStore => 'bg-orange-lt',
            self::MovingToDestination => 'bg-teal-lt',
            self::Completed => 'bg-green-lt',
            self::Cancelled, self::DriverDeclined,
            self::CustomerDeclined, self::DriverCanceled,
            self::CustomerCanceled => 'bg-red-lt',
            self::Failed => 'bg-dark-lt',
            self::Preparing => 'bg-indigo-lt',
            self::Draft => 'bg-gray-lt',
            self::Canceled => 'bg-red-darker',
        };
    }


}

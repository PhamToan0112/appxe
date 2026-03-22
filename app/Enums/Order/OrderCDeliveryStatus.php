<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderCDeliveryStatus: string
{
    use Enum;

    // Chờ tài xế xác nhận
    case PendingDriverConfirmation = "pending_driver_confirmation";

    // Chờ khách hàng xác nhận
    case PendingCustomerConfirmation = "pending_customer_confirmation";

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

    // Đang giao hàng
    case InTransit = "in_transit";

    // Đơn hàng đã hoàn thành
    case Completed = "completed";


    // Đã trả hàng
    case Returned = "returned";

    // Tài xế đã hủy đơn hàng
    case DriverCanceled = "driver_canceled";

    // Khách hàng đã hủy đơn hàng
    case CustomerCanceled = "customer_canceled";

    public function badge(): string
    {
        return match ($this) {
            self::PendingDriverConfirmation => 'bg-orange-lt',
            self::PendingCustomerConfirmation => 'bg-cyan-lt',
            self::DriverConfirmed => 'bg-blue-lt',
            self::CustomerConfirmed => 'bg-green',
            self::InTransit => 'bg-purple-lt',
            self::PickingUp => 'bg-yellow-lt',
            self::Completed => 'bg-green-lt',
            self::DriverDeclined,
            self::DriverCanceled, self::CustomerCanceled,
            self::CustomerDeclined => 'bg-red-lt',
            self::Returned => 'bg-lightblue-lt',

        };
    }

}

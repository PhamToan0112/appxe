<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderCRideCarStatus: string
{
    use Enum;

    // Đơn hàng đã hoàn thành
    case Pending = "pending";
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

    // Đơn hàng đang trong quá trình di chuyển
    case InTransit = "in_transit";

    // Đơn hàng đã hoàn thành
    case Completed = "completed";

    case DriverCanceled = "driver_canceled";

    case CustomerCanceled = "customer_canceled";

    public function badge(): string
    {
        return match ($this) {
            self::PendingDriverConfirmation, self::Pending => 'bg-orange-lt',
            self::PendingCustomerConfirmation => 'bg-cyan-lt',
            self::DriverConfirmed => 'bg-blue-lt',
            self::CustomerConfirmed => 'bg-green',
            self::InTransit => 'bg-purple-lt',
            self::Completed => 'bg-green-lt',
            self::DriverCanceled, self::CustomerCanceled, self::DriverDeclined, self::CustomerDeclined => 'bg-red-lt',

        };
    }

}

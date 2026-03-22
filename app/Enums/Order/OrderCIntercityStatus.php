<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderCIntercityStatus: string
{
    use Enum;

    // Chờ tài xế xác nhận
    case PendingDriverConfirmation = "pending_driver_confirmation";

    // Tài xế đã xác nhận
    case DriverConfirmed = "driver_confirmed";

    // Tài xế đã từ chối đơn hàng
    case DriverDeclined = "driver_declined";

    // Đơn hàng đã hoàn thành
    case Completed = "completed";


    // Tài xế đã hủy đơn hàng
    case DriverCanceled = "driver_canceled";

    // Khách hàng đã hủy đơn hàng
    case CustomerCanceled = "customer_canceled";


    public function badge(): string
    {
        return match ($this) {
            self::PendingDriverConfirmation => 'bg-orange-lt',
            self::DriverConfirmed => 'bg-blue-lt',
            self::Completed => 'bg-green-lt',
            self::DriverDeclined,
            self::DriverCanceled, self::CustomerCanceled => 'bg-red-lt',


        };
    }

}

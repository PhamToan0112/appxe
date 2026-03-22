<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderCMultiStatus: string
{
    use Enum;

    // Đơn hàng đang chuẩn bị
    case Preparing = "preparing";

    // Đơn hàng bản nháp
    case Draft = "draft";

    case Confirmed = "confirmed";

    case Pending = "pending";

    // Tài xế đã hủy đơn hàng
    case DriverCanceled = "driver_canceled";

    // Khách hàng đã hủy đơn hàng
    case CustomerCanceled = "customer_canceled";

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-lt',
            self::Preparing => 'bg-indigo-lt',
            self::Draft => 'bg-gray-lt',
            self::Confirmed => 'bg-blue-lt',
            self::DriverCanceled, self::CustomerCanceled => 'bg-red-lt',

        };
    }

}

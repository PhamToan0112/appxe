<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum DriverOrderStatus: int
{
    use Enum;

    /** Chưa có đơn */
    case NotReceived = 1;

    /** Đang chờ xác nhận đơn */
    case PendingConfirmation = 2;

    /** Đã nhận đơn */
    case Received = 3;

    /** Đang chuyển đơn */
    case InTransit = 4;

    public function badge(): string
    {
        return match ($this) {
            self::NotReceived => 'bg-green',
            self::PendingConfirmation => 'bg-yellow',
            self::Received => 'bg-blue',
            self::InTransit => 'bg-orange',
        };
    }



}

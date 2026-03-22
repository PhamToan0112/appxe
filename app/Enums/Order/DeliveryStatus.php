<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum DeliveryStatus: string
{
    use Enum;

    /** Giao hàng ngay */
    case IMMEDIATE = 'immediate';

    /** Giao hàng hẹn giờ */
    case SCHEDULED = 'scheduled';

    public function badge(): string
    {
        return match ($this) {
            DeliveryStatus::IMMEDIATE => 'bg-blue',
            DeliveryStatus::SCHEDULED => 'bg-green',
        };
    }

}

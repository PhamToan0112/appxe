<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderType: string
{
    use Enum;

    /**
     * Đơn hàng đặt xe (Ride)
     */
    case C_RIDE = 'C_RIDE';

    /**
     * Đơn hàng đặt xe (Car)
     */
    case C_CAR = 'C_CAR';

    /**
     * Đơn hàng liên tỉnh
     */
    case C_Intercity = 'C_INTERCITY';

    /**
     * Đơn hàng giao hàng
     */
    case C_Delivery = 'C_DELIVERY';

    /**
     * Đơn hàng đa điểm (Multi-point order)
     */
    case C_Multi = 'C_MULTI';


    public function badge(): string
    {
        return match ($this) {
            self::C_RIDE => 'bg-yellow-lt',
            self::C_CAR => 'bg-green-lt',
            self::C_Intercity => 'bg-blue-lt',
            self::C_Delivery => 'bg-orange-lt',
            self::C_Multi => 'bg-purple-lt',

        };
    }

}

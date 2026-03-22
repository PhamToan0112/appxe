<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum TripType: string
{
    use Enum;

    /**
     * Chuyến đi một chiều
     */
    case ONE_WAY = 'one_way';

    /**
     * Chuyến đi khứ hồi
     */
    case ROUND_TRIP = 'round_trip';


    public function badge(): string
    {
        return match ($this) {
            self::ONE_WAY => 'bg-red-lt',
            self::ROUND_TRIP => 'bg-blue-lt',

        };
    }

}

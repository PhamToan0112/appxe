<?php

namespace App\Enums\Vehicle;

use App\Supports\Enum;

enum VehicleType: string
{
    use Enum;

    /** Xe 2 bánh */
    case Motorcycle = "MOTORCYCLE";

    /** Xe 4 bánh */
    case Car4 = "CAR_4";

    case Car7 = "CAR_7";


    public function badge(): string
    {
        return match ($this) {

            self::Motorcycle => 'bg-orange-lt',
            self::Car4 => 'bg-blue-lt',
            self::Car7 => 'bg-green-lt',
        };
    }

}

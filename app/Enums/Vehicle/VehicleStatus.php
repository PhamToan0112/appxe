<?php

namespace App\Enums\Vehicle;

use App\Supports\Enum;

enum VehicleStatus: int
{
    use Enum;

    // Chờ xác nhận
    case Pending = 1;

    // hoạt động
    case Active = 2;

    // Không hoạt động
    case Inactive = 3;

    case Deleted = 4;

    // Đang bảo trì
    case UnderMaintenance = 5;


    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-green-lt',
            self::Inactive, self::Deleted => 'bg-red-lt',
            self::UnderMaintenance => 'bg-blue-lt',
            self::Active => 'bg-purple-lt'
        };
    }


}

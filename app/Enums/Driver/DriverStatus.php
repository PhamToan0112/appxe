<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum DriverStatus: int
{
    use Enum;

    /** Trạng thái Chờ xác nhận */
    case PendingConfirmation = 1;

    /** Trạng thái khoá */
    case Lock = 2;

    /**  Trạng thái hoạt động */
    case Active = 3;

    /**  Trạng thái Dừng hoạt động */
    case Inactive = 4;

    public function badge(): string
    {
        return match ($this) {
            self::Lock => 'bg-red',
            self::PendingConfirmation => 'bg-yellow',
            self::Active => 'bg-green',
            self::Inactive => 'bg-orange',
        };
    }

}

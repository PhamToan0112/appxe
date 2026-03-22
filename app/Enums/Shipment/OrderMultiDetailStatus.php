<?php

namespace App\Enums\Shipment;


use App\Admin\Support\Enum;

enum OrderMultiDetailStatus: string
{
    use Enum;

    // Đang chờ
    case Pending = 'pending';

    // Đang giao
    case Delivering = "delivering";

    // Đã đến
    case Delivered = "delivered";

    // Đã giao

    case Completed = "completed";

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow',
            self::Delivering => 'bg-gray-lt',
            self::Delivered => 'bg-red-lt',
            self::Completed => 'bg-green-lt',
        };
    }
}

<?php

namespace App\Enums\Shipment;


use App\Admin\Support\Enum;

enum ShipmentStatus: string
{
    use Enum;

    // Đơn hàng đang chuẩn bị
    case Preparing = "preparing";

    // Đơn hàng bản nháp
    case Draft = "draft";

    case Deleted = "deleted";

    // Đơn hàng chưa phân loại
    case Unsorted = "unsorted";

    //đã lên đơn
    case Ordered = "ordered";

    public function badge(): string
    {
        return match ($this) {
            self::Preparing => 'bg-indigo-lt',
            self::Draft => 'bg-gray-lt',
            self::Deleted => 'bg-red-lt',
            self::Ordered => 'bg-blue-lt',
            self::Unsorted => 'bg-primary-lt',
        };
    }
}

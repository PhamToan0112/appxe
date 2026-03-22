<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum ShippingProgressStatus: string
{
    use Enum;

    // Đang chờ xử lý
    case Pending = 'pending';

    // Đang giao hàng
    case InProgress = 'in_progress';

    // Giao hàng thành công
    case Delivered = 'delivered';

    // Đã trả hàng
    case Returned = 'returned';


    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-lt',
            self::InProgress => 'bg-blue-lt',
            self::Delivered => 'bg-green-lt',
            self::Returned => 'bg-gray-lt',

        };
    }

}

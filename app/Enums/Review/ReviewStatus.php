<?php
namespace App\Enums\Review;

use App\Supports\Enum;

enum ReviewStatus: string
{
    use Enum;

    //Đang chờ duyệt
    case Pending = "pending";

    //Đã Phê duyệt
    case Active = "active";

    //Đã xoá
    case Deleted = "deleted";

    public function badge():string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-lt',
            self::Active => 'bg-green-lt',
            self::Deleted => 'bg-red-lt',
        };
    }

}


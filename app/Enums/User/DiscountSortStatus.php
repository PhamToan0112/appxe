<?php

namespace App\Enums\User;


use App\Admin\Support\Enum;

enum DiscountSortStatus: string
{
    use Enum;

    /** Giảm giá nhiều nhất */
    case Most = "Most";

    /** Giảm giá ít nhất */
    case Least = "Least";
}

<?php

namespace App\Enums\Discount;

use App\Supports\Enum;

enum DiscountOption: int
{
    use Enum;

    case None = 0;
    case All = 1;
    case One = 2;
}

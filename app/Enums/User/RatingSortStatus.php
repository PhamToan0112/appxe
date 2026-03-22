<?php

namespace App\Enums\User;


use App\Admin\Support\Enum;

enum RatingSortStatus: string
{
    use Enum;

    /** Đánh giá cao nhất */
    case Highest = "Highest";

    /** Đánh giá thấp nhất */
    case Lowest = "Lowest";
}

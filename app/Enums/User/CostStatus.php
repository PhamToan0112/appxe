<?php

namespace App\Enums\User;


use App\Admin\Support\Enum;

enum CostStatus: string
{
    use Enum;

    /** Chi phí thấp nhất */
    case Lowest = "Lowest";

    /** Chi phí cao nhất */
    case Highest = "Highest";
}

<?php

namespace App\Enums\User;


use App\Admin\Support\Enum;

enum DistanceStatus: string
{
    use Enum;

    /** Gần nhất */
    case Nearest = "Nearest";

    /** Xa nhất */
    case Farthest = "Farthest";
}

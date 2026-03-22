<?php

namespace App\Enums\User;


use App\Admin\Support\Enum;

enum TimeStatus: string
{
    use Enum;

    /** mới nhất */
    case Newest = "Newest";

    /** cũ nhất */
    case Oldest = "Oldest";
}

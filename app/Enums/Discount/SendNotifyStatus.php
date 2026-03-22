<?php

namespace App\Enums\Discount;


use App\Admin\Support\Enum;

enum SendNotifyStatus: int
{
    use Enum;

    case NotYet = 0;
    case Sent = 1;
}
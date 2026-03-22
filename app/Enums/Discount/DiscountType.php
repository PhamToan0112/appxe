<?php

namespace App\Enums\Discount;


use App\Admin\Support\Enum;

enum DiscountType: int
{
    use Enum;

    case Money = 1;
    case Percent = 2;

    public function badge(): string
    {
        return match ($this) {
            DiscountType::Money => 'bg-green',
            DiscountType::Percent => '',
        };
    }
}

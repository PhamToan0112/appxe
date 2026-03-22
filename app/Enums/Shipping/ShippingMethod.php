<?php

namespace App\Enums\Shipping;


use App\Admin\Support\Enum;

enum ShippingMethod: int
{
    use Enum;

    //Giao hàng tiêu chuẩn
    case Standard  = 1;

    //Giao hàng nhanh
    case Overnight   = 2;

    public function badge(): string
    {
        return match($this) {
            ShippingMethod::Standard => 'bg-green-lt',
            ShippingMethod::Overnight => 'bg-red-lt',
        };
    }
}

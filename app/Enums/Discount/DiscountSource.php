<?php

namespace App\Enums\Discount;


use App\Admin\Support\Enum;

enum DiscountSource: string
{
    use Enum;

    case Admin = "ADMIN";

    case Driver = "DRIVER";

    case User = "USER";

    public function badge(): string
    {
        return match ($this) {
            DiscountSource::Admin => 'bg-green',
            DiscountSource::Driver => 'bg-blue',
            DiscountSource::User => 'bg-yellow',
            default => 'bg-gray',
        };
    }
}

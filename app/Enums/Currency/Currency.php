<?php

namespace App\Enums\Currency;


use App\Supports\Enum;

enum Currency: string
{
    use Enum;

    /** Việt Nam Đồng */
    case VND = 'VND';
    /** US Dollar */
    case USD = 'USD';
    /** Euro */
    case EUR = 'EUR';
    /** Japanese Yen */
    case JPY = 'JPY';
    /** British Pound */
    case GBP = 'GBP';
}


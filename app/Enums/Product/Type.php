<?php

namespace App\Enums\Product;

use App\Supports\Enum;

enum Type: int
{
    use Enum;
    /**
     * The product is in stock and available for purchase.
     */
    case One = 1;

    /**
     * The product is out of stock and not available for purchase.
     */
    case Many = 2;




}

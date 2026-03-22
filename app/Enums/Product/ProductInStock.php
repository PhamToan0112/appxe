<?php

namespace App\Enums\Product;

use App\Supports\Enum;

enum ProductInStock: int
{
    use Enum;
    case InStock = 1;
    case OutOfStock = 2;
}

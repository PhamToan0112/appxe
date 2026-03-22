<?php

namespace App\Enums\Product;

use App\Supports\Enum;

enum ProductStatus: int
{
    use Enum;
    case Active = 1;
    case InActive = 2;
}

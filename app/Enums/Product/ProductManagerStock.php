<?php

namespace App\Enums\Product;

use App\Supports\Enum;

enum ProductManagerStock: int
{
    use Enum;
    case Managed = 1;
    case NotManaged = 2;
}

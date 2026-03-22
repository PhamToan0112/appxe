<?php

namespace App\Enums\Address;

use App\Supports\Enum;

enum AddressDefaultStatus: string
{
    use Enum;

    case DEFAULT = 'default';
    case NOT_DEFAULT = 'not_default';


}

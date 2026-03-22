<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum AutoAccept: int
{
    use Enum;

    case Auto = 1;
    case Off = 2;
    case Locked = 3;
    public function badge(): string
    {
        return match($this) {
            AutoAccept::Auto => 'bg-green-lt',
            AutoAccept::Off => 'bg-gray-lt',
            AutoAccept::Locked => 'bg-red-lt',

        };
    }
}

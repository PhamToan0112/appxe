<?php

namespace App\Enums\Area;

use App\Admin\Support\Enum;

enum AreaStatus: int
{
    use Enum;

    case On = 1;
    case Off = 2;

    public function badge(): string
    {
        return match($this) {
            AreaStatus::On => 'bg-green',
            AreaStatus::Off => 'bg-red',
        };
    }
}

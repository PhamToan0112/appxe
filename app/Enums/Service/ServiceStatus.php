<?php

namespace App\Enums\Service;

use App\Admin\Support\Enum;

enum ServiceStatus: int
{
    use Enum;

    case On = 1;
    case Off = 2;

    public function badge(): string
    {
        return match($this) {
            ServiceStatus::On => 'bg-green',
            ServiceStatus::Off => 'bg-red',
        };
    }
}

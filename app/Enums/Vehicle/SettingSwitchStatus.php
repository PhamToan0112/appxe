<?php

namespace App\Enums\Vehicle;


use App\Admin\Support\Enum;

enum SettingSwitchStatus: string
{
    use Enum;

    case OPEN = '1';

    case OFF = '0';


    public function badge(): string
    {
        return match ($this) {
            SettingSwitchStatus::OPEN => 'bg-red',
            SettingSwitchStatus::OFF => 'bg-blue',

        };
    }
}

<?php

namespace App\Enums\Vehicle;


use App\Admin\Support\Enum;

enum LicensePlateColor: int
{
    use Enum;


    case White = 1;

    case Yellow = 2;


    public function badge(): string
    {
        return match ($this) {
            LicensePlateColor::White => 'bg-white',
            LicensePlateColor::Yellow => 'bg-yellow',
        };
    }
}

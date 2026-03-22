<?php

namespace App\Enums\Address;

use App\Supports\Enum;

enum AddressType: string
{
    use Enum;

    case HOME = 'home';
    case WORK = 'work';
    case SCHOOL = 'school';
    case OTHER = 'other';
    
    public function label(): string
    {
        return match($this) {
            self::HOME => 'Nhà riêng',
            self::WORK => 'Cơ quan',
            self::SCHOOL => 'Trường học',
            self::OTHER => 'Khác',
        };
    }
}

<?php

namespace App\Enums\Driver;

use App\Admin\Support\Enum;

enum DriverReviews: int
{
    use Enum;

    case Bad = 1;
    case Good = 2;

    public function badge(): string
    {
        return match ($this) {
            self::Good => 'bg-green-lt',
            self::Bad => 'bg-red-lt',
        };
    }

    public static function fromRating(float $rating): self
    {
        return match (true) {
            $rating >= 4.0 => self::Good,
            $rating >= 1.0 && $rating < 4.0 => self::Bad,
        };
    }
}
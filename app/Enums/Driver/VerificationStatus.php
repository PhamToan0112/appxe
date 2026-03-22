<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum VerificationStatus: int
{
    use Enum;

    case Unverified = 1;
    case Verified = 2;

    case Cancelled = 3;

    public function badge(): string
    {
        return match ($this) {
            VerificationStatus::Verified => 'bg-green-lt',
            VerificationStatus::Unverified => 'bg-gray--lt',
            VerificationStatus::Cancelled => 'bg-red-lt',
        };
    }
}
<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum PaymentRole: string
{
    use Enum;

    /**
     * Người gửi thanh toán
     */
    case SENDER = 'sender';

    /**
     * Người nhận thanh toán
     */
    case RECIPIENT = 'recipient';

    public function badge(): string
    {
        return match ($this) {
            PaymentRole::SENDER => 'bg-blue',
            PaymentRole::RECIPIENT => 'bg-green',
        };
    }

}

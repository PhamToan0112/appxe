<?php

namespace App\Enums\Transaction;


use App\Supports\Enum;

enum TransactionType: string
{
    use Enum;

    /** Nạp tiền */
    case Deposit = 'deposit';

    /** Rút tiền */
    case Withdraw = 'withdraw';

    /** Rút tiền */
    case Payment = 'payment';

    public function badge(): string
    {
        return match ($this) {
            TransactionType::Deposit => 'bg-green',
            TransactionType::Withdraw => 'bg-red',
            TransactionType::Payment => 'bg-blue',
        };
    }
}


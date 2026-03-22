<?php

namespace App\Enums\Transaction;


use App\Supports\Enum;

enum TransactionStatus: string
{
    use Enum;

    /** Chưa xóa */
    case NOT_DELETED = 'not_deleted';

    /** Đã xóa */
    case DELETED = 'deleted';

    public function badge(): string
    {
        return match ($this) {
            TransactionStatus::NOT_DELETED => 'bg-green',
            TransactionStatus::DELETED => 'bg-red',
        };
    }
}


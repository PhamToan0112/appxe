<?php

namespace App\Models;

use App\Enums\DeleteStatus;
use App\Enums\Transaction\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';


    protected $fillable = [
        /** wallet_id */
        'wallet_id',
        /** Loại giao dịch */
        'type',
        /** Số tiền giao dịch  */
        'amount',
        /** Mã giao dịch */
        'code',
        'is_deleted',

    ];


    protected $casts = [
        'type' => TransactionType::class,
        'is_deleted' => DeleteStatus::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}

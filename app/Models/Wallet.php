<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Enums\Currency\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';


    protected $fillable = [
        /** User Id */
        'user_id',
        /** Số dư hiện tại */
        'balance',
        /** Đơn vị tiền tệ  */
        'currency',
        /** Trạng thái */
        'status'
    ];


    protected $casts = [
        'status' => ActiveStatus::class,
        'currency' => Currency::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'wallet_id', 'id');
    }

}

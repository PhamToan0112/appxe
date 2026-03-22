<?php

namespace App\Models;

use App\Enums\Driver\DriverTransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverTransaction extends Model
{
    use HasFactory;

    protected $table = 'driver_transactions';

    protected $guarded = [];

    protected $casts = [
        'status' => DriverTransactionStatus::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }


}

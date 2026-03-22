<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderIssue extends Model
{
    use HasFactory;

    protected $table = 'order_issues';

    protected $fillable = [
        /** Order ID */
        'order_id',
        /** Mô tả */
        'description',

    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


}

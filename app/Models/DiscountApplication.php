<?php

namespace App\Models;

use App\Enums\Discount\SendNotifyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountApplication extends Model
{
    use HasFactory;

    protected $table = 'discount_applications';

    public $timestamps = false;
    protected $fillable = [
        'discount_code_id',
        'user_id',
        'driver_id',
        'order_id',
        /*Đánh dấu đã thông báo cho người dùng*/
        'notified',
    ];

    protected $casts = [
        'notified' => SendNotifyStatus::class,
    ];

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_code_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

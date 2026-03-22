<?php

namespace App\Models;

use App\Enums\Review\ReviewStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    protected $fillable = [
        /** ID của người dùng */
        'user_id',
        /** ID của tài xế */
        'driver_id',
        /** ID của đơn hàng */
        'order_id',
        /** Số sao đánh giá */
        'rating',
        /** Nội dung đánh giá */
        'content',
        /** Trạng thái */
        'status'
    ];
    protected $casts = [
        'status' => ReviewStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
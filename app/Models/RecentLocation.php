<?php

namespace App\Models;

use App\Enums\Order\OrderType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecentLocation extends Model
{
    use HasFactory;

    protected $table = 'recent_locations';

    protected $fillable = [
        /** ID của người dùng */
        'user_id',
        /** Vĩ độ của điểm bắt đầu */
        'start_latitude',
        /** Kinh độ của điểm bắt đầu */
        'start_longitude',
        /** Địa chỉ của điểm bắt đầu */
        'start_address',
        /** Vĩ độ của điểm kết thúc */
        'end_latitude',
        /** Kinh độ của điểm kết thúc */
        'end_longitude',
        /** Địa chỉ của điểm kết thúc */
        'end_address',
        /** Loại điểm */
        'order_type'
    ];
    protected $casts = [
        'order_type' => OrderType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

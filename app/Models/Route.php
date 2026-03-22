<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        /** ID của tài xế */
        'driver_id',
        /** Địa chỉ bắt đầu của tuyến đường */
        'start_address',
        /** Vĩ độ của điểm bắt đầu */
        'start_lat',
        /** Kinh độ của điểm bắt đầu */
        'start_lng',
        /** Địa chỉ kết thúc của tuyến đường */
        'end_address',
        /** Vĩ độ của điểm kết thúc */
        'end_lat',
        /** Kinh độ của điểm kết thúc */
        'end_lng',
        /** Giá vé của tuyến đư��ng */
        'price',
        /** Giá khứ hồi */
        'return_price',
        /** Thời gian khởi hành */
        'departure_time'
    ];


    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function routeVariants(): HasMany
    {
        return $this->hasMany(RouteVariant::class);
    }
}

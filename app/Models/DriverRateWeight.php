<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverRateWeight extends Model
{
    use HasFactory;

    protected $table = 'driver_rate_weights';

    protected $fillable = [
        /** ID của tài xế */
        'driver_id',
        /** ID của khoảng trọng lượng */
        'shipping_weight_range_id',
        /** Giá cước cho khoảng trọng lượng */
        'price',

    ];

    protected $casts = [

    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }


    public function weightRange(): BelongsTo
    {
        return $this->belongsTo(WeightRange::class, 'shipping_weight_range_id');
    }


}

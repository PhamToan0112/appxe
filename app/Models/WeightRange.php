<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeightRange extends Model
{
    use HasFactory;

    protected $table = 'shipping_weight_ranges';


    protected $fillable = [
        /** Trọng lượng tối thiểu của khoảng cân (kg) */
        'min_weight',
        /** Trọng lượng tối đa của khoảng cân (kg) */
        'max_weight',
        /** Trạng thái hoạt động của khoảng cân */
        'status',
    ];


    protected $casts = [
        'status' => DefaultStatus::class
    ];

    public function driverRates(): HasMany
    {
        return $this->hasMany(DriverRateWeight::class, 'shipping_weight_range_id');
    }
}

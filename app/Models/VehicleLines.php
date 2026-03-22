<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleLines extends Model
{
    use HasFactory;

    protected $table = 'vehicle_lines';

    protected $fillable = [
        /** Tên dòng xe */
        'name',
        /** Mô tả dòng xe */
        'description',
        /** Trạng thái dòng xe */
        'status'
    ];
    protected $casts = [
        'status' => DefaultStatus::class,

    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'vehicle_line_id');
    }
}

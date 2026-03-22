<?php

namespace App\Models;

use App\Enums\Order\TripType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteVariant extends Model
{
    use HasFactory;

    protected $table = 'route_variants';

    protected $fillable = [
        'route_id',
        'departure_time',
        'price',
        'start_address',
        'end_address',
        'trip_type'
    ];

    protected $casts = [
        'trip_type' => TripType::class
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}

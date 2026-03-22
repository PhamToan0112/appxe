<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        /** Tên khu vực */
        'name',
        /** Trạng thái khu vực */
        'status',
        /** Vị trí khu vực */
        'description',

    ];


    protected $casts = [
        'status' => ActiveStatus::class
    ];
    public function shipments(): BelongsToMany
    {
        return $this->belongsToMany(Shipment::class, 'shipment_categories', 'category_id', 'shipment_id');
    }

    public function multiPointDetails(): BelongsToMany
    {
        return $this->belongsToMany(OrderMultiPointDetail::class, 'multi_point_detail_category', 'category_id', 'multi_point_detail_id');
    }

}

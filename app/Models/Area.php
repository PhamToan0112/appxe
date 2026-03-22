<?php

namespace App\Models;

use App\Enums\Area\AreaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        /** Tên khu vực */
        'name',
        /** Trạng thái khu vực */
        'status',
        /** Vị trí khu vực */
        'position',
        /** Địa chỉ khu vực */
        'address',
        /** Kinh độ */
        'lng',
        /** Vĩ độ */
        'lat',
        /** Ranh giới khu vực */
        'boundaries',
        /** Phí dịch vụ */
        'fee',
        /** Trạng thái cao điểm */
        'peak_status',
    ];


    protected $casts = [
        'status' => AreaStatus::class,
        'peak_status' => AreaStatus::class
    ];
}

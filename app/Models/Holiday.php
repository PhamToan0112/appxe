<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = 'holidays';

    protected $fillable = [
        /** Tên ngày nghỉ */
        'name',
        /** Thời gian nghỉ */
        'date',
        /** Trạng thái của ngày nghỉ */
        'status'
    ];


    protected $casts = [
        'status' => DefaultStatus::class
    ];


}

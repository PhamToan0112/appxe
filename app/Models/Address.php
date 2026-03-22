<?php

namespace App\Models;

use App\Enums\Address\AddressDefaultStatus;
use App\Enums\Address\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        /** ID người dùng */
        'user_id',
        /** Tên địa chỉ chi tiết*/
        'address',
        /** Vĩ độ */
        'latitude',
        /** Kinh độ */
        'longitude',
        /** Loại địa chỉ */
        'type',
        /** Tên địa chỉ */
        'name',
        'default_status'
    ];


    protected $casts = [
        'type' => AddressType::class,
        'default_status' => AddressDefaultStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

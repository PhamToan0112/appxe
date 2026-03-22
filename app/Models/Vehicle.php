<?php

namespace App\Models;

use App\Enums\Vehicle\LicensePlateColor;
use App\Enums\Vehicle\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Order\OrderType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        /** ID tài xế */
        'driver_id',
        /** ID dòng xe */
        'vehicle_line_id',
        /** Code */
        'code',
        /** Tên phương tiện */
        'name',
        /** Màu sắc */
        'color',
        /** Loại phương tiện */
        'type',
        /** Số ghế */
        'seat_number',
        /** Biển số xe */
        'license_plate',
        /** Giá */
        'price',
        /** Ảnh đại diện xe */
        'avatar',
        /** Ảnh biển số xe */
        'license_plate_image',
        /** Nhà sản xuất xe */
        'vehicle_company',
        /** Giấy đăng ký xe mặt trước */
        'vehicle_registration_front',
        /** Giấy đăng ký xe mặt sau */
        'vehicle_registration_back',
        /** Ảnh xe phía trước */
        'vehicle_front_image',
        /** Ảnh xe phía sau */
        'vehicle_back_image',
        /** Ảnh hông xe */
        'vehicle_side_image',
        /** Ảnh nội thất xe */
        'vehicle_interior_image',
        /** Ảnh mặt trước bảo hiểm xe */
        'insurance_front_image',
        /** Ảnh mặt sau bảo hiểm xe */
        'insurance_back_image',
        /** Tiện nghi */
        'amenities',
        /** Mô tả */
        'description',
        /** Năm sản xuất */
        'production_year',
        /** Màu biển số (chỉ dành cho xe ô tô) */
        'license_plate_color',
        /** Trạng thái */
        'status',
        /** Loại dịch vụ */
        'service_type',
    ];

    protected $casts = [
        'name' => 'string',
        'color' => 'string',
        'seat_number' => 'integer',
        'license_plate' => 'string',
        'type' => VehicleType::class,
        'license_plate_color' => LicensePlateColor::class,
        'status' => VehicleStatus::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($vehicle) {
            $vehicle->code = uniqid_real();
        });
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicleLine(): BelongsTo
    {
        return $this->belongsTo(VehicleLines::class, 'vehicle_line_id');
    }

}
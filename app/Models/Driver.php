<?php

namespace App\Models;

use App\Admin\Traits\Roles;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\Service\ServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Roles;

    protected $table = 'drivers';

    protected $fillable = [
        /**  ID người dùng */
        'user_id',
        /** CCCD */
        'id_card',
        /** CCCD mặt trước */
        'id_card_front',
        /** CCCD mặt sau */
        'id_card_back',
        /** Giấy phép lái xe mặt trước */
        'driver_license_front',
        /** Giấy phép lái xe mặt sau */
        'driver_license_back',
        /** Giá booking */
        'booking_price',
        /** Tự động chấp nhận đơn */
        'auto_accept',
        /** Vĩ độ hiện tại */
        'current_lat',
        /** Kinh độ hiện tại */
        'current_lng',
        /** Địa chỉ hiện tại */
        'current_address',
        /** Tình trạng đơn hàng đã chấp nhận */
        'order_status',
        /** Tên người liên hệ khẩn cấp */
        'emergency_contact_name',
        /** Địa chỉ người liên hệ khẩn cấp */
        'emergency_contact_address',
        /** Số điện thoại người liên hệ khẩn cấp */
        'emergency_contact_phone',
        /** Thời gian bắt đầu dịch vụ */
        'service_start_time',
        /** Thời gian kết thúc dịch vụ */
        'service_end_time',
        /** Dịch vụ C-Ride/C-Car */
        'service_ride',
        /** Giá dịch vụ C-Ride/C-Car */
        'service_ride_price',
        /** Dịch vụ giao hàng ngay C-Delivery Now */
        'service_delivery_now',
        /** Giá dịch vụ giao hàng ngay C-Delivery Now */
        'service_delivery_now_price',
        /** Dịch vụ giao hàng sau C-Delivery Later */
        'service_delivery_later',
        /** Giá dịch vụ giao hàng sau C-Delivery Later */
        'delivery_later_fee_per_stop',
        /** Dịch vụ liên thành phố C-Intercity */
        'service_intercity',
        /** Giá dịch vụ liên thành phố C-Intercity */
        'service_intercity_price',
        /** Thời gian bắt đầu dịch vụ liên thành phố C-Intercity */
        'service_intercity_start_time',
        /** Thời gian kết thúc dịch vụ liên thành phố C-Intercity */
        'service_intercity_end_time',
        /** Dịch vụ xe hơi Service Car */
        'service_car',
        /** Giá dịch vụ xe hơi Service Car */
        'service_car_price',
        /** Giá thu hộ thấp nhất */
        'min_earning',
        /** Giá thu hộ cao nhất */
        'max_earning',
        /** Giá tiền giờ cao điểm */
        'peak_hour_price',
        /** Giá tiền sau 23h đêm */
        'night_time_price',
        /** Giá tiền ngày lễ */
        'holiday_price',
        /** Tình trạng xác nhận */
        'is_verified',
    ];
    protected $casts = [
        'auto_accept' => AutoAccept::class,
        'order_accepted' => DriverStatus::class,
        'service_car' => ServiceStatus::class,
        'service_ride' => ServiceStatus::class,
        'service_delivery_now' => ServiceStatus::class,
        'service_delivery_later' => ServiceStatus::class,
        'service_intercity' => ServiceStatus::class,
        'is_verified' => VerificationStatus::class,
        'service_intercity_start_time' => 'datetime',
        'service_intercity_end_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'driver_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class, 'driver_id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'driver_id');
    }

    public function rateWeights(): HasMany
    {
        return $this->hasMany(DriverRateWeight::class, 'driver_id');
    }

    public function scopeDriver($query)
    {
        return $query->whereHas('user.roles', function ($query) {
            $query->where('name', $this->getRoleDriver());
        });
    }
}

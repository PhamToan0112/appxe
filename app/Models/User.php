<?php

namespace App\Models;

use App\Admin\Support\Eloquent\Sluggable;
use App\Enums\ActiveStatus;
use App\Enums\Currency\Currency;
use App\Enums\OpenStatus;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\User\{CostStatus, DiscountSortStatus, DistanceStatus, Gender, RatingSortStatus, TimeStatus, UserStatus};

class User extends Authenticatable implements JWTSubject
{
    use HasRoles, Sluggable, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $columnSlug = 'fullname';

    protected $fillable = [
        /** Tên người dùng */
        'username',
        /** Mã người dùng */
        'code',
        /** Đường dẫn tĩnh */
        'slug',
        /** Họ và tên */
        'fullname',
        /** Mật khẩu */
        'password',
        /** Email */
        'email',
        /** Số điện thoại */
        'phone',
        /** Ngày sinh */
        'birthday',
        /** Giới tính */
        'gender',
        /** Trạng thái online*/
        'active',
        /** Ảnh đại diện */
        'avatar',
        /** ID khu vực */
        'area_id',
        /** ID ngân hàng */
        'bank_id',
        /** Trạng thái người dùng */
        'status',
        /** Token thiết bị */
        'device_token',
        /** Tùy chọn thông báo */
        'notification_preference',
        /** Thời gian xác thực email */
        'email_verified_at',
        /** Số tài khoản ngân hàng */
        'bank_account_number',
        /** Tùy chọn ưu tiên xe */
        'car_life',
        /** Tùy chọn ưu tiên chi phí */
        'cost_preference',
        /** Tùy chọn ưu tiên đánh giá */
        'rating_preference',
        /** Tùy chọn ưu tiên giảm giá */
        'discount_preference',
        /** Tùy chọn ưu tiên khoảng cách */
        'distance_preference',
        /** Loại xe */
        'vehicle_type',
        /** Cài đặt giá */
        'price_setting_c_car',

    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => Gender::class,
        'active' =>  OpenStatus::class,
        'status' => UserStatus::class,
        'car_life' => TimeStatus::class,
        'cost_preference' => CostStatus::class,
        'rating_preference' => RatingSortStatus::class,
        'discount_preference' => DiscountSortStatus::class,
        'distance_preference' => DistanceStatus::class,
        'vehicle_type' => VehicleType::class,

    ];


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->withPivot('model_type')
            ->wherePivot('model_type', self::class);
    }


    public function checkPermissions($permissionsArr): bool
    {
        foreach ($permissionsArr as $permission) {
            if ($this->can($permission)) {
                return true;
            }
        }
        return false;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class, 'user_id', 'id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    protected static function booted(): void
    {
        static::created(function ($user) {
            $user->wallet()->create([
                'balance' => 0,
                'currency' => Currency::VND,
                'status' => ActiveStatus::Active
            ]);
        });
    }
}

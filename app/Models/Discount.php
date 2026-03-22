<?php

namespace App\Models;

use App\Enums\Discount\DiscountOption;
use App\Enums\Discount\DiscountSource;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $dates = ['date_start', 'date_end'];

    protected $fillable = [
        /** Mã giảm giá */
        'code',
        /** Ngày bắt đầu */
        'date_start',
        /** Ngày kết thúc */
        'date_end',
        /** Số lần sử dụng tối đa */
        'max_usage',
        /** Giá trị đơn hàng tối thiểu */
        'min_order_amount',
        /** Loại giảm giá */
        'type',
        /** Giá trị giảm giá */
        'discount_value',
        /** Phần trăm giảm giá */
        'percent_value',
        /** Trạng thái của mã giảm giá */
        'status',
        /** Nguồn gốc của mã giảm giá */
        'source',
        /** Mô tả */
        'description',
        /** Tùy chọn giảm giá cho tất cả, cho thành viên cụ thể */
        'user_option',
        /** Tùy chọn giảm giá cho tất cả, cho tài xế cụ thể */
        'driver_option',
    ];

    protected $casts = [
        'type' => DiscountType::class,
        'status' => DiscountStatus::class,
        'source' => DiscountSource::class,
        'user_option' => DiscountOption::class,
        'driver_option' => DiscountOption::class,
    ];


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'discount_applications', 'discount_code_id', 'order_id');
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'discount_applications', 'discount_code_id', 'driver_id')
            ->withPivot('notified');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discount_applications', 'discount_code_id', 'user_id')
            ->withPivot('notified');
    }

    public function discount_applications(): HasMany
    {
        return $this->hasMany(DiscountApplication::class, 'discount_code_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query
            ->where('date_start', '<=', Carbon::now())
            ->where('date_end', '>=', Carbon::now())
            ->where('status', '=', DiscountStatus::Published)
            ->where(function ($query) {
                $query->where('max_usage', '>', 0)
                    ->orWhereNull('max_usage');
            });
    }

    public function scopeExpired($query)
    {
        return $query->where(function ($query) {
            $query->where('date_end', '<', Carbon::now())
                ->orWhere('max_usage', '=', 0)
                ->orWhereNull('max_usage');
        });
    }



    /**
     * Check if the discount code is still active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        if ($this->status !== DiscountStatus::Published) {
            return false;
        }

        if ($now->greaterThan($this->date_start) && $now->lessThan($this->date_end)) {
            if ($this->max_usage !== null && $this->max_usage <= 0) {
                return false;
            }
            return true;
        }

        return false;
    }


}

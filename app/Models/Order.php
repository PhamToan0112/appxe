<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        /** ID của người dùng */
        'user_id',
        /** ID của tài xế */
        'driver_id',
        /** ID của phương tiện  */
        'vehicle_id',
        /** ID của mã giảm giá */
        'discount_id',
        /** Số tiền giảm */
        'discount_amount',
        /** code */
        'code',
        /** Vĩ độ hiện tại */
        'current_lat',
        /** Kinh độ hiện tại */
        'current_lng',
        /** Địa chỉ hiện tại */
        'current_address',
        /** Ngày bắt đầu */
        'start_date',
        /** Ngày kết thúc */
        'end_date',
        /** Tổng tiền phụ của đơn hàng */
        'sub_total',
        /** Phí nền tảng*/
        'platform_fee',
        /** phí đa điểm */
        'multi_point_fee',
        /** Mã thanh toán */
        'payment_code',
        /** Phương thức giao hàng */
        'shipping_method',
        /** Phương thức thanh toán */
        'payment_method',
        /** Địa chỉ giao hàng */
        'shipping_address',
        /** Loại đơn hàng */
        'order_type',
        /** Tổng tiền của đơn hàng */
        'total',
        /** Giá tham khảo */
        'reference_price',
        /** Trạng thái của đơn hàng */
        'status',
        /** Ghi chú cho đơn hàng */
        'note',
        /** Giờ khởi hành */
        'departure_time',
        /** Giờ quay về */
        'return_time',
        /** Số lượng khách */
        'passenger_count',
        /** Ngày giao hàng */
        'delivery_date',
        /** Giờ giao hàng */
        'delivery_time',
        /** tiền đối ứng trước */
        'advance_payment_amount',
        /** Giá mong muốn */
        'desired_price',
        /** Số tiền phí vùng cao điểm */
        'high_point_area_fee',
        /** Số tiền phí ngày lễ */
        'holiday_fee',
        /** Số tiền phí giờ đêm */
        'night_time_fee',
        /** Hình ảnh đơn hàng */
        'order_confirmation_image',
        /** Hình ảnh trả hàng */
        'return_image',
        /** Trạng thái xác nhận người thanh toán */
        'payment_role',
        /** Trạng thái giao hàng */
        'delivery_status',
        /** Trạng thái đối ứng trước */
        'advance_payment_status',
        /** Trạng thái xoá */
        'is_deleted',
        /** Trạng thái chuyến đi*/
        'trip_type',
        /** Lý do hủy */
        'reason_cancel',

    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
        'order_type' => OrderType::class,
        'trip_type' => TripType::class,
        'is_deleted' => DefaultStatus::class,
        'delivery_status' => DeliveryStatus::class,
        'payment_role' => PaymentRole::class,
        'collection_from_sender_status' => OpenStatus::class,
        'advance_payment_status' => OpenStatus::class,
        'total' => 'double',
        'departure_time' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->BelongsTo(Vehicle::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id');
    }


    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }


    public function issues(): HasMany
    {
        return $this->hasMany(OrderIssue::class, 'order_id');
    }

    public function shipments(): BelongsToMany
    {
        return $this->belongsToMany(Shipment::class, 'order_shipments', 'order_id', 'shipment_id');
    }


    public function multiPointDetails(): HasMany
    {
        return $this->hasMany(OrderMultiPointDetail::class, 'order_id');
    }

}

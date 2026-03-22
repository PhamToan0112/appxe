<?php

namespace App\Models;

use App\Enums\OpenStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\Order\OrderMultiPointStatus;
class OrderMultiPointDetail extends Model
{
    use HasFactory;

    protected $table = 'order_multi_point_details';

    protected $fillable = [
        /** ID của đơn hàng */
        'order_id',
        /** weight_range_id */
        'weight_range_id',
        /** Vĩ độ của điểm bắt đầu */
        'start_latitude',
        /** Kinh độ của điểm bắt đầu */
        'start_longitude',
        /** Địa chỉ của điểm bắt đầu */
        'start_address',
        /** Vĩ độ của điểm kết thúc */
        'end_latitude',
        /** Kinh độ của điểm kết thúc */
        'end_longitude',
        /** Địa chỉ của điểm kết thúc */
        'end_address',
        /** Tên người nhận */
        'recipient_name',
        /** Số điện thoại người nhận */
        'recipient_phone',
        /** Trạng thái thu hộ người gửi */
        'collection_from_sender_status',
        /** Số tiền thu hộ khi giao hàng */
        'collect_on_delivery_amount',
        /** Trạng thái giao hàng */
        'delivery_status'
    ];

    protected $casts = [
        'collection_from_sender_status' => OpenStatus::class,
        'delivery_status' =>OrderMultiPointStatus::class
    ];

    public function weightRange(): BelongsTo
    {
        return $this->belongsTo(WeightRange::class, 'weight_range_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'multi_point_detail_category', 'multi_point_detail_id', 'category_id');
    }



}

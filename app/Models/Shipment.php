<?php

namespace App\Models;

use App\Enums\DeleteStatus;
use App\Enums\OpenStatus;
use App\Enums\Shipment\OrderMultiDetailStatus;
use App\Enums\Shipment\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    protected $fillable = [
        /** ID của người dùng */
        'user_id',
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
        /** Trạng thái thu hộ người gửi */
        'collection_from_sender_status',
        /** Số tiền thu hộ  */
        'collect_on_delivery_amount',
        /** Tên người nhận */
        'recipient_name',
        /** Số điện thoại người nhận */
        'recipient_phone',
        /** Kinh độ của người gửi*/
        'sender_longitude',
        /** Vĩ độ của người gửi*/
        'sender_latitude',
        /** Tên người gửi */
        'sender_name',
        /** Số điện thoại người gửi */
        'sender_phone',
        /** Khoảng cách */
        'distance',
        /** Trạng thái đã xoá */
        'is_deleted',
        /** Trạng thái của shipment */
        'shipment_status',



    ];

    protected $casts = [
        'collection_from_sender_status' => OpenStatus::class,
        'shipment_status' => ShipmentStatus::class,
        'delivery_status' => OrderMultiDetailStatus::class,
        'is_deleted' => DeleteStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function weightRange(): BelongsTo
    {
        return $this->belongsTo(WeightRange::class, 'weight_range_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shipment_categories', 'shipment_id', 'category_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_shipments', 'shipment_id', 'order_id');
    }



}

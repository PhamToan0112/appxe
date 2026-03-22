<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class OrderCDeliveryRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:orders,id'],
            'user_id' => ['required', 'exists:users,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'weight_range_id' => ['required', 'exists:shipping_weight_ranges,id'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'address' => ['required'],
            'end_lat' => ['required', 'numeric'],
            'end_lng' => ['required', 'numeric'],
            'end_address' => ['required'],
            'status' => ['required', new Enum(OrderCDeliveryStatus::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'payment_role' => ['required', new Enum(PaymentRole::class)],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'total' => ['required'],
            'platform_fee' => ['required', 'numeric'],
            'distance' => ['nullable'],
            'note' => ['nullable', 'string'],
            'order_confirmation_image' => ['nullable', 'string'],
            'return_image' => ['nullable', 'string'],
            'advance_payment_amount' => ['nullable', 'numeric'],
            'delivery_date' => ['nullable', 'date'],
            'delivery_time' => ['nullable', 'date_format:H:i'],
            'recipient_phone' => ['required', 'string'],
            'recipient_name' => ['required', 'string'],
            'sender_name' => ['nullable'],
            'sender_phone' => ['nullable'],
            'delivery_status' => ['required', new Enum(DeliveryStatus::class)],
            'categories' => ['nullable', 'array'],
            'holiday_fee' => ['nullable', 'integer'],
            'night_time_fee' => ['nullable', 'integer'],
            'high_point_area_fee' => ['nullable', 'integer'],
        ];
    }
}
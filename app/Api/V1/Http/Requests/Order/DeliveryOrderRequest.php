<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class DeliveryOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'note' => ['nullable'],
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'start_address' => ['required'],
            'end_latitude' => ['required', 'numeric'],
            'end_longitude' => ['required', 'numeric'],
            'end_address' => ['required'],
            'total' => ['required', 'numeric'],
            'sub_total' => ['required', 'numeric'],
            'platform_fee' => ['required', 'numeric'],
            'desired_price' => ['nullable', 'numeric'],
            'delivery_date' => ['nullable', 'date'],
            'delivery_time' => ['nullable', 'date_format:H:i'],
            'distance' => ['nullable'],
            'weight_range_id' => ['required', 'exists:shipping_weight_ranges,id'],
            'sender_name' => ['required', 'string'],
            'sender_phone' => ['required'],
            'recipient_name' => ['required', 'string'],
            'recipient_phone' => ['required',],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'payment_role' => ['required', new Enum(PaymentRole::class)],
            'delivery_status' => ['required', new Enum(DeliveryStatus::class)],
            'advance_payment_status' => ['required', new Enum(OpenStatus::class)],
            'advance_payment_amount' => ['nullable', 'numeric'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],

        ];
    }


}

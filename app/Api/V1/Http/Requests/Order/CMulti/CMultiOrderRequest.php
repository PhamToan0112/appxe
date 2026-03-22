<?php

namespace App\Api\V1\Http\Requests\Order\CMulti;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class CMultiOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'delivery_status' => ['required', new Enum(DeliveryStatus::class)],
            'delivery_date' => ['nullable', 'date'],
            'delivery_time' => ['nullable', 'date_format:H:i'],
            'platform_fee' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'shipment_ids' => 'required|array',
            'shipment_ids.*' => 'exists:shipments,id',
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],
            'high_point_area_fee' => ['nullable', 'numeric'],
            'holiday_fee' => ['nullable', 'numeric'],
            'night_time_fee' => ['nullable', 'numeric'],
        ];
    }

}

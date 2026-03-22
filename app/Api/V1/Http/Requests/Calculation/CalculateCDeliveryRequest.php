<?php

namespace App\Api\V1\Http\Requests\Calculation;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;

class CalculateCDeliveryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function methodPost(): array
    {
        return [
            'driver_id' => 'nullable|exists:drivers,id',
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'end_latitude' => ['required', 'numeric'],
            'end_longitude' => ['required', 'numeric'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],
            'weight_range_id' => 'required|exists:shipping_weight_ranges,id',
            'delivery_status' => ['required', new Enum(DeliveryStatus::class)],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'advance_payment_amount' => ['required', 'numeric'],
        ];
    }


}

<?php

namespace App\Api\V1\Http\Requests\Calculation\CRideCar;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\In;

class CalculateBookCarRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'driver_id' => 'nullable|exists:drivers,id',
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'end_latitude' => ['required', 'numeric'],
            'end_longitude' => ['required', 'numeric'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'order_type' => ['required', new In([OrderType::C_RIDE->value,
                OrderType::C_CAR->value, OrderType::C_Delivery->value])],
            'discount_id' => ['nullable', 'exists:discounts,id',
                new ValidDiscount($this->input('discount_id'))],
        ];
    }


}

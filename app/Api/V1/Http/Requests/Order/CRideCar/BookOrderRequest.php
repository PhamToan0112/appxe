<?php

namespace App\Api\V1\Http\Requests\Order\CRideCar;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class BookOrderRequest extends BaseRequest
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
            'distance' => ['required'],
            'order_type' => ['required', new Enum(OrderType::class)],
            'desired_price' => ['nullable', 'numeric'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Order,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['nullable', 'numeric'],
            'sub_total' => ['nullable', 'numeric'],
            'platform_fee' => ['nullable', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],
            'high_point_area_fee' => ['nullable', 'numeric'],
            'holiday_fee' => ['nullable', 'numeric'],
            'night_time_fee' => ['nullable', 'numeric'],
            'desired_price' => ['nullable', 'numeric'],
        ];
    }


}

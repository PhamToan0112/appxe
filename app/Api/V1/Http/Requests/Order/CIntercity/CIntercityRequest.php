<?php

namespace App\Api\V1\Http\Requests\Order\CIntercity;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class CIntercityRequest extends BaseRequest
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
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required', 'numeric'],
            'sub_total' => ['required', 'numeric'],
            'platform_fee' => ['required', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'distance' => ['nullable'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],
            'trip_type' => ['required', new Enum(TripType::class)],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'departure_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'return_time' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'passenger_count' => ['required', 'integer', 'min:1'],
            'reference_price' => ['nullable', 'numeric'],
            'high_point_area_fee' => ['nullable', 'numeric'],
            'holiday_fee' => ['nullable', 'numeric'],
            'night_time_fee' => ['nullable', 'numeric'],
        ];
    }


}

<?php

namespace App\Api\V1\Http\Requests\Calculation;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;

class CalculateCIntercityRequest extends BaseRequest
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
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'trip_type' => ['required', new Enum(TripType::class)],
            'route_variant_id' => ['required', 'exists:route_variants,id'],
            'passenger_count' => ['required', 'integer'],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],

        ];
    }



}

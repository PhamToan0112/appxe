<?php

namespace App\Api\V1\Http\Requests\Calculation\CRideCar;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\In;

class CalculateBookCarDriverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'id' => 'required|exists:orders,id',
            'order_type' => ['required', new In([OrderType::C_RIDE->value,
                OrderType::C_CAR->value])],
        ];
    }


}

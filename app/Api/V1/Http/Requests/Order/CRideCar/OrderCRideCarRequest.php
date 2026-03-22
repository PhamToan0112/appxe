<?php

namespace App\Api\V1\Http\Requests\Order\CRideCar;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\Enum;


class OrderCRideCarRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'page' =>'required|integer',
            'limit' => 'sometimes|required|integer|min:1',
            'order_type' => ['required', new Enum(OrderType::class)],
            'status' => ['sometimes', new Enum(OrderStatus::class)]

        ];
    }

}

<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\Enum;


class OrderActiveRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
//            'order_type' => ['required', new Enum(OrderType::class)],

        ];
    }


}

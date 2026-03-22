<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\Enum;


class CheckOrderRequest extends BaseRequest
{


    protected function methodPost(): array
    {
        return [
            'order_type' => ['required', new Enum(OrderType::class)],

        ];
    }

}

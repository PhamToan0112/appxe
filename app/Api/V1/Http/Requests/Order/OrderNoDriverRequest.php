<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\Enum;


class OrderNoDriverRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'order_type' => ['nullable', new Enum(OrderType::class)],
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],
        ];
    }


}

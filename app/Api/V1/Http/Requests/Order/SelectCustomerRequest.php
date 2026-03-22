<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;


class SelectCustomerRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut(): array
    {
        return [
            'code' => 'required|string|exists:orders,code',
            'driver_id' => 'required|string'
        ];
    }

}

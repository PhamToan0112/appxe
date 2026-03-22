<?php

namespace App\Api\V1\Http\Requests\Discount;

use App\Api\V1\Http\Requests\BaseRequest;


class CheckDiscountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'sub_total' => 'required|numeric',
            'driver_id' => 'required|exists:App\Models\Driver,id',
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],
        ];
    }
}

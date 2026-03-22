<?php

namespace App\Api\V1\Http\Requests\Discount;

use App\Api\V1\Http\Requests\BaseRequest;


class DiscountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],
        ];
    }
    protected function methodPost(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}

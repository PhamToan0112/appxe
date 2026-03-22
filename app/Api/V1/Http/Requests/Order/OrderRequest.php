<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;


class OrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPatch(): array
    {
        return [
            'code' => 'required|string|exists:orders,code',
            'status' => 'required|string',
            'reason_cancel' => 'nullable|string',
        ];
    }
    protected function methodPost(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'reports' => 'required|array',
            'reports.*' => 'string',
            'return_image' => 'required|image|max:2048'
        ];
    }

}

<?php

namespace App\Api\V1\Http\Requests\ReportOrder;

use App\Api\V1\Http\Requests\BaseRequest;

class ReportOrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'description' => ['required', 'string'],
        ];
    }
}
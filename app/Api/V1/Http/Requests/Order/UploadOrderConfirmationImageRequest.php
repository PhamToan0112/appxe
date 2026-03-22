<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;


class UploadOrderConfirmationImageRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'id' => 'required|integer|exists:orders,id',
            'order_confirmation_image' => 'required|image|max:2048',
        ];

    }


}

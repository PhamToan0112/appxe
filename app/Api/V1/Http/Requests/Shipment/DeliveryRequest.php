<?php

namespace App\Api\V1\Http\Requests\Shipment;

use App\Api\V1\Http\Requests\BaseRequest;


class DeliveryRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'id' => ['required', 'string', 'exists:shipments,id'],
            'delivery_success_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }


}

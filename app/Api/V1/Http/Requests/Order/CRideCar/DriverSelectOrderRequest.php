<?php

namespace App\Api\V1\Http\Requests\Order\CRideCar;

use App\Api\V1\Http\Requests\BaseRequest;



class DriverSelectOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPatch(): array
    {
        return [
            'id' => 'required|integer|exists:orders,id',
        ];
    }



}

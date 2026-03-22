<?php

namespace App\Api\V1\Http\Requests\Order\CMulti;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderMultiPointStatus;
use Illuminate\Validation\Rules\Enum;


class MultiPointOrderDetailRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPatch(): array
    {
        return [
            'multi_point_detail_id' => ['required', 'array'],
            'multi_point_detail_id.*' => ['integer', 'exists:order_multi_point_details,id'],
            'delivery_status' => ['required', new Enum(OrderMultiPointStatus::class)],
        ];
    }


}

<?php

namespace App\Api\V1\Http\Requests\Shipment;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Shipment\ShipmentStatus;
use Illuminate\Validation\Rules\Enum;


class ShipmentStatusRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPatch(): array
    {
        return [
            'shipment_ids' => ['required', 'array'],
            'shipment_ids.*' => ['integer', 'exists:shipments,id'],
            'status' => ['required', new Enum(ShipmentStatus::class)],
        ];
    }


}

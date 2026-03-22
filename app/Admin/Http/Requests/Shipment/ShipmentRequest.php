<?php

namespace App\Admin\Http\Requests\Shipment;

use App\Admin\Http\Requests\BaseRequest;

class ShipmentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Shipment,id'],
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'weight_range_id' => ['required', 'exists:App\Models\WeightRange,id'],
            'end_address' => ['required'],
            'recipient_name' => ['required'],
            'recipient_phone' => ['required', 'numeric'],
            'collection_from_sender_status' => ['required', 'in:ON,OFF'],
            'collect_on_delivery_amount' => ['nullable'],
            'shipment_status' => ['required'],
            'categories' => ['nullable', 'array'],
            'lat' => ['required'],
            'lng' => ['required'],
            'end_lat' => ['required'],
            'end_lng' => ['required'],
            'address' => ['required'],
        ];
    }
}

<?php

namespace App\Api\V1\Http\Requests\Shipment;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\OpenStatus;
use Illuminate\Validation\Rules\Enum;


class ShipmentRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'start_address' => ['required'],
            'end_latitude' => ['required', 'numeric'],
            'end_longitude' => ['required', 'numeric'],
            'end_address' => ['required'],
            'weight_range_id' => ['required', 'exists:shipping_weight_ranges,id'],
            'recipient_name' => ['required', 'string'],
            'recipient_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:App\Models\User,phone'],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'collect_on_delivery_amount' => ['nullable'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['exists:categories,id'],

        ];
    }


}

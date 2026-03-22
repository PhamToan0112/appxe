<?php

namespace App\Api\V1\Http\Requests\Order\CMulti;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\OpenStatus;
use App\Enums\Shipment\ShipmentStatus;
use Illuminate\Validation\Rules\Enum;


class ShipmentRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodDelete(): array
    {
        return [
            'shipment_ids' => 'required|array',
        ];
    }

    protected function methodGet(): array
    {
        return [
            'type' => ['nullable', new Enum(ShipmentStatus::class)],

        ];
    }

    protected function methodPost(): array
    {
        return [
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'start_address' => ['required', 'string', 'max:255'],
            'end_latitude' => ['required', 'numeric'],
            'end_longitude' => ['required', 'numeric'],
            'end_address' => ['required', 'string', 'max:255'],
            'weight_range_id' => ['required', 'integer', 'exists:shipping_weight_ranges,id'],
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_phone' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'max:255'],
            'collection_from_sender_status' => ['required', new Enum(OpenStatus::class)],
            'collect_on_delivery_amount' => ['nullable', 'numeric'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id']
        ];
    }


}

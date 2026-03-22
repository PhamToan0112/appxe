<?php

namespace App\Admin\Http\Requests\OrderMultiPointDetail;

use Illuminate\Validation\Rules\Enum;
use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Order\OrderMultiPointStatus;

class OrderMultiPointDetailRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\OrderMultiPointDetail,id'],
            'weight_range_id' => ['required', 'exists:App\Models\WeightRange,id'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'address' => ['required'],
            'end_lat' => ['required', 'numeric'],
            'end_lng' => ['required', 'numeric'],
            'end_address' => ['required'],
            'recipient_name' => ['required'],
            'recipient_phone' => ['required'],
            'collection_from_sender_status' => ['required', 'in:ON,OFF'],
            'delivery_status' => ['required', new Enum(OrderMultiPointStatus::class)],
            'collect_on_delivery_amount' => ['nullable'],
            'categories' => ['nullable', 'array'],
        ];
    }
}

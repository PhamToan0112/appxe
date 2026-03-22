<?php

namespace App\Api\V1\Http\Requests\Calculation;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Discount\ValidDiscount;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;

class CalculateCMultiRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function methodPost(): array
    {
        return [
            'shipment_ids' => 'required|array|min:1',
            'shipment_ids.*' => 'exists:shipments,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'discount_id' => ['nullable', 'exists:discounts,id', new ValidDiscount($this->input('discount_id'))],

        ];
    }



}

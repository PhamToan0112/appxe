<?php

namespace App\Api\V1\Http\Requests\Discount;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Discount\DiscountType;
use App\Enums\Discount\DiscountStatus;
use Illuminate\Validation\Rules\Enum;

class DiscountStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'max_usage' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric',
            'type' => ['required', new Enum(DiscountType::class)],
            'discount_value' => 'nullable|numeric',
            'percent_value' => 'nullable|numeric|gt:0|lte:100',
            'description' => 'required|string',
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Discount,id'],
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'max_usage' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric',
            'type' => ['required', new Enum(DiscountType::class)],
            'status' => ['required', new Enum(DiscountStatus::class)],
            'discount_value' => 'nullable|numeric',
            'percent_value' => 'nullable|numeric|gt:0|lte:100',
            'description' => 'required|string',
        ];
    }
}
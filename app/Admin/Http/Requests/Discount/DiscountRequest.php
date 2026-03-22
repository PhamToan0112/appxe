<?php

namespace App\Admin\Http\Requests\Discount;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Discount\DiscountOption;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use Illuminate\Validation\Rules\Enum;


class DiscountRequest extends BaseRequest
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
            'user_option' => ['required', new Enum(DiscountOption::class)],
            'driver_option' => ['required', new Enum(DiscountOption::class)],
            'user_ids' => 'required_if:user_option,' . DiscountOption::One->value,
            'user_ids.*' => 'exists:users,id',
            'driver_ids' => 'required_if:driver_option,' . DiscountOption::One->value,
            'driver_ids.*' => 'exists:drivers,id',
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Discount,id'],
            'code' => 'required|string|unique:discounts,code,' . $this->id,
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'max_usage' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric',
            'type' => ['required', new Enum(DiscountType::class)],
            'status' => ['required', new Enum(DiscountStatus::class)],
            'discount_value' => 'nullable|numeric',
            'percent_value' => 'nullable|numeric|gt:0|lte:100',
            'description' => 'required|string',
            'user_option' => ['required', new Enum(DiscountOption::class)],
            'driver_option' => ['required', new Enum(DiscountOption::class)],
            'user_ids.*' => 'exists:users,id',
            'driver_ids.*' => 'exists:drivers,id',
        ];
    }
}
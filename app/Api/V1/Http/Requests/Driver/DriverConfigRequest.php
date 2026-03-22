<?php

namespace App\Api\V1\Http\Requests\Driver;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Driver\AutoAccept;
use App\Enums\OpenStatus;
use Illuminate\Validation\Rules\Enum;

class DriverConfigRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut(): array
    {
        return [
            'service_ride' => ['required'],
            'service_ride_price' => ['nullable'],
            'service_car' => ['required'],
            'service_car_price' => ['nullable'],
            'service_delivery_now' => ['required'],
            'service_delivery_now_price' => ['nullable'],
            'service_delivery_later' => ['required'],
            'delivery_later_fee_per_stop' => ['nullable'],
            'service_intercity' => ['required'],
            'service_intercity_price' => ['nullable'],
            'service_intercity_start_time' => ['nullable'],
            'service_intercity_end_time' => ['nullable'],
            'peak_hour_price' => ['nullable'],
            'night_time_price' => ['nullable'],
            'holiday_price' => ['nullable'],
            'weight_ranges' => ['nullable', 'array'],
            'weight_ranges.*.id' => ['nullable'],
            'weight_ranges.*.price' => ['nullable'],
            'active' => ['required', new Enum(OpenStatus::class)],
            'auto_accept' => ['required', new Enum(AutoAccept::class)],
        ];
    }

    protected function methodGet()
    {
        return [
            'driver_id' => ['required'],
            'distance' => ['required'],
            'order_type' => ['required'],
        ];
    }
}

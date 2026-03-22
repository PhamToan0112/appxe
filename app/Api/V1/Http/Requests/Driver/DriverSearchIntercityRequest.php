<?php

namespace App\Api\V1\Http\Requests\Driver;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderType;
use App\Enums\User\CostStatus;
use App\Enums\User\DiscountSortStatus;
use App\Enums\User\DistanceStatus;
use App\Enums\User\TimeStatus;
use App\Enums\User\RatingSortStatus;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Validation\Rules\Enum;

class DriverSearchIntercityRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'cost_preference' => ['nullable', new Enum(CostStatus::class)],
            'vehicles' => ['nullable', new Enum(TimeStatus::class)],
            'discount' => ['nullable', new Enum(DiscountSortStatus::class)],
            'review' => ['nullable', new Enum(RatingSortStatus::class)],
            'type' => ['nullable', new Enum(VehicleType::class)],
            'price_setting' => ['nullable', 'integer' , 'gt:0'],
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'end_lat' => ['required', 'numeric'],
            'end_lng' => ['required', 'numeric'],
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'route_variant_id' => ['required', 'exists:route_variants,id'],
            'passenger_count' => ['required', 'integer'],
        ];
    }
}

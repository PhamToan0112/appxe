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

class DriverSearchRequest extends BaseRequest
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
            'discount' => ['nullable', new Enum(DiscountSortStatus::class)],
            'review' => ['nullable', new Enum(RatingSortStatus::class)],
            'vehicles' => ['nullable', new Enum(TimeStatus::class)],
            'price_setting' => ['nullable', 'integer'],
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'end_lat' => ['required', 'numeric'],
            'end_lng' => ['required', 'numeric'],
        ];
    }
}

<?php

namespace App\Api\V1\Http\Resources\Driver;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DriverConfigsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'active' => $this->user->active,
            'auto_accept' => $this->auto_accept,
            'service_ride' => $this->service_ride,
            'service_ride_price' => $this->service_ride_price,

            'service_car' => $this->service_car,
            'service_car_price' => $this->service_car_price,

            'service_delivery_now' => $this->service_delivery_now,
            'service_delivery_now_price' => $this->service_delivery_now_price,

            'service_delivery_later' => $this->service_delivery_later,
            'delivery_later_fee_per_stop' => $this->delivery_later_fee_per_stop,

            'service_intercity' => $this->service_intercity,
            'service_intercity_price' => $this->service_intercity_price,
            'service_intercity_start_time' => format_time($this->service_intercity_start_time, 'H:i'),
            'service_intercity_end_time' => format_time($this->service_intercity_end_time, 'H:i'),
            'peak_hour_price' => $this->peak_hour_price,
            'night_time_price' => $this->night_time_price,
            'holiday_price' => $this->holiday_price,

            'weight_ranges' => $this->rateWeights->map(function ($rateWeight) {
                return [
                    'id' => $rateWeight->weightRange->id,
                    'min_weight' => $rateWeight->weightRange->min_weight,
                    'max_weight' => $rateWeight->weightRange->max_weight,
                    'price' => $rateWeight->price,
                ];
            }),
        ];
    }
}

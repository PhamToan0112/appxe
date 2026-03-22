<?php

namespace App\Api\V1\Http\Resources\Order\CMulti;

use App\Api\V1\Http\Resources\Order\CRideCar\DriverCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class MultiPointDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     * */

    public function toArray($request): array|JsonSerializable|Arrayable
    {

        return [
            'weight_range' => new WeightRangeResource($this->weightRange),
            'start_latitude' => $this->start_latitude,
            'start_longitude' => $this->start_longitude,
            'start_address' => $this->start_address,
            'end_latitude' => $this->end_latitude,
            'end_longitude' => $this->end_longitude,
            'end_address' => $this->end_address,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'collect_on_delivery_amount' => $this->collect_on_delivery_amount,
        ];
    }
}

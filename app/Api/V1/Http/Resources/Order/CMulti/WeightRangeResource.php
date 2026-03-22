<?php

namespace App\Api\V1\Http\Resources\Order\CMulti;

use App\Api\V1\Http\Resources\Order\CRideCar\DriverCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class WeightRangeResource extends JsonResource
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
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
        ];
    }
}

<?php

namespace App\Api\V1\Http\Resources\Order\CRideCar;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class VehicleCRideCarResource extends JsonResource
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
            'name' => $this->name,
            'license_plate' => $this->license_plate,
            'type' => $this->type,
        ];
    }
}

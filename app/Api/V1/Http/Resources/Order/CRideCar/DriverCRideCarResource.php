<?php

namespace App\Api\V1\Http\Resources\Order\CRideCar;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DriverCRideCarResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->user->fullname,
            'phone' => $this->user->phone,
            'avatar' => formatImageUrl($this->user->avatar),
            'vehicles' => VehicleCRideCarResource::collection($this->vehicles),

        ];
    }
}

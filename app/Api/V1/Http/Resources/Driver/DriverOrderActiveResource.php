<?php

namespace App\Api\V1\Http\Resources\Driver;


use App\Api\V1\Http\Resources\Vehicle\VehicleOrderActiveResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DriverOrderActiveResource extends JsonResource
{
    protected $orderType;

    public function __construct($resource, $orderType)
    {
        parent::__construct($resource);
        $this->orderType = is_string($orderType) ? $orderType : $orderType->value;

    }
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $filteredVehicles = $this->vehicles->filter(function ($vehicle) {
            return $vehicle->service_type == $this->orderType;
        });
        return [
            'id' => $this->id,
            'fullname' => $this->user->fullname,
            'avatar' => $this->user->avatar,
            'phone' => $this->user->phone,
            'vehicles' => VehicleOrderActiveResource::collection($filteredVehicles),

        ];
    }
}

<?php

namespace App\Api\V1\Http\Resources\Route;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {

        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'start_address' => $this->start_address,
            'end_address' => $this->end_address,
            'price' => $this->price,
            'return_price' => $this->return_price,
            'departure_time' => $this->departure_time,
            'type' => $this->trip_type

        ];
    }
}

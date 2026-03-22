<?php

namespace App\Api\V1\Http\Resources\Shipment;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ShipmentOrderActiveResource extends JsonResource
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
            'start_latitude' => $this->start_latitude,
            'start_longitude' => $this->start_longitude,
            'start_address' => $this->start_address,
            'end_latitude' => $this->end_latitude,
            'end_longitude' => $this->end_longitude,
            'end_address' => $this->end_address,
            'sender_name' => $this->sender_name,
            'sender_phone' => $this->sender_phone,
        ];
    }
}

<?php

namespace App\Api\V1\Http\Resources\Order\CMulti;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     *
     * @throws Exception
     */

    public function toArray($request): array|JsonSerializable|Arrayable
    {

        return [
            'id' => $this->id,
            'user' => [
                'fullname' => $this->user->fullname
            ],
            'start_address' => $this->start_address,
            'start_latitude' => $this->start_latitude,
            'start_longitude' => $this->start_longitude,
            'end_latitude' => $this->end_latitude,
            'end_longitude' => $this->end_longitude,
            'end_address' => $this->end_address,
            'shipment_status' => $this->shipment_status,
            'created_at' => format_datetime($this->created_at)
        ];
    }
}

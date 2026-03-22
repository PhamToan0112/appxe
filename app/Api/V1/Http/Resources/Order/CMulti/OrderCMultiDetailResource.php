<?php

namespace App\Api\V1\Http\Resources\Order\CMulti;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderCMultiDetailResource extends JsonResource
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
            'start_latitude' =>$this->start_latitude,
            'start_longitude' => $this->start_longitude,
            'start_address'=> $this->start_address,
            'end_latitude' => $this->end_latitude,
            'end_longitude' => $this->end_longitude,
            'end_address' => $this->end_address,
            'delivery_status' => $this->delivery_status

        ];
    }
}

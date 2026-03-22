<?php

namespace App\Api\V1\Http\Resources\Order;

use App\Api\V1\Http\Resources\Shipment\ShipmentCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderSearchResource extends JsonResource
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
            'code' => $this->code,
            'order_type' => $this->order_type,
            'status' => $this->status,
            'total' => $this->total,
            'created_at' => format_datetime($this->created_at),
            'delivery_date' => $this->delivery_date,
            'delivery_time' => $this->delivery_time,
            'shipment' => new ShipmentCRideCarResource($this->shipments->first()),
        ];
    }
}

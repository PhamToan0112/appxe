<?php

namespace App\Api\V1\Http\Resources\Order;

use App\Api\V1\Http\Resources\Driver\DriverOrderActiveResource;

use App\Api\V1\Http\Resources\Order\CMulti\OrderCMultiDetailResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentOrderActiveResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderActiveResource extends JsonResource
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
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'platform_fee' => $this->platform_fee,
            'status' => $this->status,
            'current_lat' => $this->current_lat,
            'current_lng' => $this->current_lng,
            'current_address' => $this->current_address,
            'shipments' => ShipmentOrderActiveResource::collection($this->shipments),
            'order_details'=>  OrderCMultiDetailResource::collection($this->multiPointDetails),
            'driver' => new DriverOrderActiveResource($this->driver, $this->order_type),
            'created_at' => format_datetime($this->created_at),
        ];
    }
}

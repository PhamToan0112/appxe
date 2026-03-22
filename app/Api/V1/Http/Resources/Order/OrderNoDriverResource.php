<?php

namespace App\Api\V1\Http\Resources\Order;

use App\Api\V1\Http\Resources\Driver\DriverOrderActiveResource;

use App\Api\V1\Http\Resources\Order\CMulti\OrderCMultiDetailResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentCRideCarResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentOrderActiveResource;
use App\Enums\Order\OrderType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderNoDriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     * */

    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $orderType = $this->order_type;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'order_type' => $this->order_type,
            'desired_price' => $this->desired_price,
            'user' => [
                'avatar' => $this->user->avatar
            ],
            'status' => $this->status,
            'shipment' => $this->shipments->first()

        ];
    }



}

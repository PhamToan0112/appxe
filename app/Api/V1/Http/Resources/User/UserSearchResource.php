<?php

namespace App\Api\V1\Http\Resources\User;

use App\Api\V1\Http\Resources\Order\CIntercity\OrderCIntercityResource;
use App\Api\V1\Http\Resources\Order\CRideCar\OrderCRideCarResource;
use App\Enums\Order\OrderType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $shipment = $this->orders->first()->shipments->first();
        $order = $this->orders->first();
        $orderResource = null;
        if ($order) {
            switch ($order->order_type) {
                case OrderType::C_Intercity->value:
                    $orderResource = new OrderCIntercityResource($order);
                    break;

                default:
                    $orderResource = new OrderCRideCarResource($order);
                    break;
            }
        }
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'avatar' => $this->avatar,
            'start_latitude' => $shipment ? $shipment->start_latitude : null,
            'start_longitude' => $shipment ? $shipment->start_longitude : null,
            'start_address' => $shipment ? $shipment->start_address : null,
            'orders' => $orderResource,
        ];
    }
}

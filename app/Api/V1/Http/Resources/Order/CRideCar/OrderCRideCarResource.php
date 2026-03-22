<?php

namespace App\Api\V1\Http\Resources\Order\CRideCar;

use App\Api\V1\Http\Resources\Discount\DiscountResource;
use App\Api\V1\Http\Resources\Review\ReviewResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderCRideCarResource extends JsonResource
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
            'customer' => new CustomerCRideCarResource($this->user),
            'driver' => new DriverCRideCarResource($this->driver),
            'payment_method' => $this->payment_method,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'platform_fee' => $this->platform_fee,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'order_confirmation_image' => formatImageUrl($this->order_confirmation_image),
            'created_at' => format_datetime($this->created_at),
            'updated_at' => format_datetime($this->updated_at),
            'shipment' => new ShipmentCRideCarResource($this->shipments->first()),
            'reviews' => ReviewResource::collection($this->reviews),
            'discount' => new DiscountResource($this->discount),
            'desired_price' => $this->desired_price,
        ];
    }
}
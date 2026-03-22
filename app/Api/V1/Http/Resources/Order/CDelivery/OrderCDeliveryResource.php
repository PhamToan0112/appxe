<?php

namespace App\Api\V1\Http\Resources\Order\CDelivery;

use App\Api\V1\Http\Resources\Category\CategoryOrderResource;
use App\Api\V1\Http\Resources\Discount\DiscountResource;
use App\Api\V1\Http\Resources\Order\CIntercity\CustomerCIntercityResource;
use App\Api\V1\Http\Resources\Order\CRideCar\DriverCRideCarResource;
use App\Api\V1\Http\Resources\Review\ReviewResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderCDeliveryResource extends JsonResource
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
            'driver' => new DriverCRideCarResource($this->driver),
            'customer' => new CustomerCDeliveryResource($this->user),
            'payment_method' => $this->payment_method,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'platform_fee' => $this->platform_fee,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'created_at' => format_datetime($this->created_at),
            'updated_at' => format_datetime($this->updated_at),
            'categories' => CategoryOrderResource::collection($this->shipments->first()->categories),
            'shipment' => new ShipmentCRideCarResource($this->shipments->first()),
            'reviews' => ReviewResource::collection($this->reviews),
            'discount' => new DiscountResource($this->discount),
            'desired_price' => $this->desired_price,
        ];
    }
}
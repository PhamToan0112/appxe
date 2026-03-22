<?php

namespace App\Api\V1\Http\Resources\Order\CIntercity;

use App\Api\V1\Http\Resources\Discount\DiscountResource;
use App\Api\V1\Http\Resources\Order\CRideCar\DriverCRideCarResource;
use App\Api\V1\Http\Resources\Review\ReviewResource;
use App\Api\V1\Http\Resources\Shipment\ShipmentCRideCarResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderCIntercityResource extends JsonResource
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
            'payment_method' => $this->payment_method,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'platform_fee' => $this->platform_fee,
            'discount_amount' => $this->discount_amount,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'departure_time' => format_datetime($this->departure_time),
            'return_time' => format_datetime($this->return_time),
            'passenger_count' => $this->passenger_count,
            'trip_type' => $this->trip_type,
            'created_at' => format_datetime($this->created_at),
            'updated_at' => format_datetime($this->updated_at),
            'shipment' => new ShipmentCRideCarResource($this->shipments->first()),
            'reviews' => ReviewResource::collection($this->reviews),
            'discount' => new DiscountResource($this->discount),
            'desired_price' => $this->desired_price,
        ];
    }
}
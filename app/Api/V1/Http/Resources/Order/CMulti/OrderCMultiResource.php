<?php

namespace App\Api\V1\Http\Resources\Order\CMulti;

use App\Api\V1\Http\Resources\Order\CRideCar\DriverCRideCarResource;
use App\Api\V1\Http\Resources\Review\ReviewResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderCMultiResource extends JsonResource
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
            'created_at' => format_datetime($this->created_at),
            'updated_at' => format_datetime($this->updated_at),
            'order_multi_points' => MultiPointDetailResource::collection($this->multiPointDetails),
            'reviews' => ReviewResource::collection($this->reviews),
        ];
    }
}

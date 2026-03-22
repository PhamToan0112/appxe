<?php

namespace App\Api\V1\Http\Resources\Driver;

use App\Api\V1\Http\Resources\Auth\AuthResource;
use App\Api\V1\Http\Resources\Discount\DiscountResource;
use App\Api\V1\Http\Resources\Vehicle\VehicleResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DriverInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'user' => $this->userInfo($this->user),
            'booking_price' =>round($this->booking_price ,1),
            'reviews' => $this->reviewInfo($this->reviews),
            'discount' => $this->discountInfo($this->discount),
            'vehicle' => $this->vehicleInfo($this->vehicle_info),
        ];
    }

    private function userInfo($user)
    {
        return [
            'name' => $user->fullname,
            'image' => formatImageUrl($user->avatar),
        ];
    }

    private function reviewInfo($reviews)
    {
        return [
            'total' => $reviews->count(),
            'avg' => round($reviews->avg('rating'), 1),
        ];
    }

    private function discountInfo($discount)
    {
        return DiscountResource::collection($discount);
    }

    private function vehicleInfo($vehicle)
    {
        if ($vehicle) {
            return [
                'name' => $vehicle->name,
                'license_plate' => $vehicle->license_plate,
            ];
        } else {
            return null;
        }

    }
}

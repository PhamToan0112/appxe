<?php

namespace App\Api\V1\Http\Resources\Driver;

use App\Api\V1\Http\Resources\Auth\AuthResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DriverResource extends JsonResource
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
            'user' => new AuthResource($this->user),
            'id_card' => $this->id_card,
            'license_plate' => $this->license_plate,
            'vehicle_company' => $this->vehicle_company,
            'bank_name' => $this->bank_name,
            'bank_account_name' => $this->bank_account_name,
            'bank_account_number' => $this->bank_account_number,
            'auto_accept' => $this->auto_accept,
            'current_lat' => $this->current_lat,
            'current_lng' => $this->current_lng,
            'current_address' => $this->current_address,
            'order_accepted' => $this->order_accepted,
            'is_locked' => $this->is_locked,
            'is_on' => $this->is_on,
            'images' => [
                'id_card_front' => formatImageUrl($this->id_card_front),
                'avatar' => formatImageUrl($this->user->avatar),
                'id_card_back' => formatImageUrl($this->id_card_back),
                'license_plate_image' => formatImageUrl($this->license_plate_image),
                'vehicle_registration_front' => formatImageUrl($this->vehicle_registration_front),
                'vehicle_registration_back' => formatImageUrl($this->vehicle_registration_back),
                'driver_license_front' => formatImageUrl($this->driver_license_front),
                'driver_license_back' => formatImageUrl($this->driver_license_back),
                'vehicle_front_image' => formatImageUrl($this->vehicle_front_image),
                'vehicle_back_image' => formatImageUrl($this->vehicle_back_image),
                'vehicle_side_image' => formatImageUrl($this->vehicle_side_image),
                'vehicle_interior_image' => formatImageUrl($this->vehicle_interior_image),
                'insurance_front_image' => formatImageUrl($this->insurance_front_image),
                'insurance_back_image' => formatImageUrl($this->insurance_back_image),
            ]
        ];
    }
}

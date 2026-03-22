<?php

namespace App\Api\V1\Http\Resources\Vehicle;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'name' => $this->name,
            'status' => $this->status,

            'driver_licence_font'=> optional($this->driver)->driver_licence_font,
            'driver_licence_back'=> optional($this->driver)->driver_licence_back,

            'card_id' => optional($this->driver)->id_card,
            'card_font' => optional(optional($this->driver))->id_card_front,
            'card_back' => optional(optional($this->driver))->id_card_back,

            'emergency_contact_name' => optional($this->driver)->emergency_contact_name,
            'emergency_contact_address' => optional($this->driver)->emergency_contact_address,
            'emergency_contact_phone' => optional($this->driver)->emergency_contact_phone,

            'vehicle_registration_front' => $this->vehicle_registration_front,
            'vehicle_registration_back' => $this->vehicle_registration_back,

            'vehicle_line' => optional($this->vehicleLine)->name,
            'vehicle_company' => $this->vehicle_company,
            'type' => $this->type,
            'production_year' => $this->production_year,
            'seat_number' => $this->seat_number,

            'vehicle_front_image' => $this->vehicle_front_image,
            'vehicle_back_image' => $this->vehicle_back_image,
            'vehicle_side_image' => $this->vehicle_side_image,
            'vehicle_interior_image' => $this->vehicle_interior_image,
            
            'license_plate' => $this->license_plate,
            'license_plate_image' => $this->license_plate_image,

            'insurance_front_image' => $this->insurance_front_image,
            'insurance_back_image' => $this->insurance_back_image,

            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),
        ];
    }
}

<?php

namespace App\Api\V1\Http\Resources\Vehicle;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class VehicleResourceCollection extends ResourceCollection
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
            'vehicles' => $this->collection->map(function ($item) {
                $data = [
                    'id' => $item->id,
                    'driver_id' => $item->driver_id,
                    'name' => $item->name,
                    'color' => $item->color,
                    'type' => $item->type,
                    'seat_number' => $item->seat_number,
                    'license_plate' => $item->license_plate,
                    'license_plate_image' => $item->license_plate_image,
                    'vehicle_company' => $item->vehicle_company,
                    'vehicle_registration_front' => $item->vehicle_registration_front,
                    'vehicle_registration_back' => $item->vehicle_registration_back,
                    'vehicle_front_image' => $item->vehicle_front_image,
                    'vehicle_back_image' => $item->vehicle_back_image,
                    'vehicle_side_image' => $item->vehicle_side_image,
                    'vehicle_interior_image' => $item->vehicle_interior_image,
                    'insurance_front_image' => $item->insurance_front_image,
                    'insurance_back_image' => $item->insurance_back_image,
                    'amenities' => $item->amenities,
                    'description' => $item->description,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'price' => $item->price,
                    'status' => $item->status,
                ];
                return $data;
            }),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'limit' => $this->perPage(),
                'total' => $this->total(),
                'count' => $this->count(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}

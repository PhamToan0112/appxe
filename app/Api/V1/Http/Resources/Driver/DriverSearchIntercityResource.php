<?php

namespace App\Api\V1\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Order\OrderType;
use App\Enums\Vehicle\VehicleStatus;

class DriverSearchIntercityResource extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'drivers' => $this->collection->map(function ($driver) {
                $vehicles = $driver->vehicles->filter(function ($vehicle) {
                    return $vehicle->status->value == VehicleStatus::Active->value &&
                        ($vehicle->type == VehicleType::Car4 || $vehicle->type == VehicleType::Car7);
                })->map(function ($vehicle) {
                    return [
                        'vehicle' => [
                            'id' => $vehicle->id,
                            'name' => $vehicle->name,
                            'type' => $vehicle->type->value,
                            'service_type' => json_decode($vehicle->service_type),
                            'license_plate' => $vehicle->license_plate,
                            'production_year' => $vehicle->production_year,
                        ],
                    ];
                });

                if ($vehicles->isNotEmpty()) {

                    return [
                        'driver_id' => $driver->id,
                        'current_lat' => $driver->current_lat,
                        'current_lng' => $driver->current_lng,
                        'driver_name' => $driver->user->fullname,
                        'driver_image' => $driver->user->avatar,
                        'price_setting_service' => $driver->price_setting_service,
                        'active_discount_count' => $driver->active_discount_count,
                        'distance' => $driver->calculateDistanceUsingGoogleAPI,
                        'rating' => round($driver->average_rating, 1),
                        'review_count' => $driver->reviews->count(),
                        'vehicles' => $vehicles->values(),
                    ];
                }
                return null;
            })->filter()->values(),
        ];
    }
}

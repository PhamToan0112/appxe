<?php
namespace App\Api\V1\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Order\OrderType;

class DriverSearchRideCarResource extends ResourceCollection
{
    protected $orderType;

    public function __construct($resource, $orderType)
    {
        parent::__construct($resource);
        $this->orderType = $orderType;
    }

    public function toArray($request): array
    {
        return [
            'drivers' => $this->collection->map(function ($driver) {
                $vehicles = $driver->vehicles->filter(function ($vehicle) {
                    return $vehicle->status->value == VehicleStatus::Active->value ;
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

                    $price_setting_service = 0;

                    switch ($this->orderType) {
                        case OrderType::C_RIDE->value:
                            $price_setting_service = $driver->service_ride_price * $driver->calculateDistanceUsingGoogleAPI;
                            break;
                        case OrderType::C_CAR->value:
                            $price_setting_service = $driver->service_car_price * $driver->calculateDistanceUsingGoogleAPI;
                            break;
                        case OrderType::C_Intercity->value:
                            $price_setting_service = $driver->service_intercity_price * $driver->calculateDistanceUsingGoogleAPI;
                            break;
                        case OrderType::C_Delivery->value:
                            $price_setting_service =  $driver->service_delivery_now_price * $driver->calculateDistanceUsingGoogleAPI;
                            break;
                        case OrderType::C_Multi->value:
                            $price_setting_service =  $driver->delivery_later_fee_per_stop * $driver->calculateDistanceUsingGoogleAPI;
                            break;
                    }

                    return [
                        'driver_id' => $driver->id,
                        'current_lat' => $driver->current_lat,
                        'current_lng' => $driver->current_lng,
                        'driver_name' => $driver->user->fullname,
                        'driver_image' => $driver->user->avatar,
                        'price_setting_service' => $price_setting_service,
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

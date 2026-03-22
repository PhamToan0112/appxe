<?php

namespace App\Admin\Repositories\RouteVariant;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Order\TripType;
use App\Models\RouteVariant;
use DateTime;
use Exception;


class RouteVariantRepository extends EloquentRepository implements RouteVariantRepositoryInterface
{


    public function getModel(): string
    {
        return RouteVariant::class;
    }

    /**
     * @throws Exception
     */
    public function createRouteVariants($startTime, $endTime, $route, $driver): void
    {
        $startDateTime = new DateTime($startTime);
        $endDateTime = new DateTime($endTime);
        $nightTimePrice = $driver->night_time_price ?? 0;

        if ((int) $startDateTime->format('i') !== 0) {
            $startDateTime->modify('+1 hour')->setTime((int) $startDateTime->format('H'), 0);
        }

        while ($startDateTime <= $endDateTime) {
            $departureTime = $startDateTime->format('H:i:s');
            $priceAdjustment = $this->calculateNightTimeSurcharge($startDateTime, $nightTimePrice);

            $this->createVariant($route, $departureTime, TripType::ONE_WAY, $route->price + $priceAdjustment);

            if ($route->return_price) {
                $this->createVariant($route, $departureTime, TripType::ROUND_TRIP, $route->return_price + $priceAdjustment);
            }

            $startDateTime->modify('+1 hour');
        }
    }


    protected function calculateNightTimeSurcharge(DateTime $dateTime, $nightTimePrice): float
    {
        $hour = (int) $dateTime->format('H');
        return ($hour >= 23 || $hour < 6) ? $nightTimePrice : 0;
    }

    protected function createVariant($route, $departureTime, $tripType, $price): void
    {
        $identifier = [
            'route_id' => $route->id,
            'departure_time' => $departureTime,
            'trip_type' => $tripType,
        ];

        $variantData = [
            'price' => $price,
            'start_address' => $route->start_address,
            'end_address' => $route->end_address,
            'trip_type' => $tripType,
        ];

        $this->updateOrCreate($identifier, $variantData);
    }
}
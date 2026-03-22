<?php

namespace App\Api\V1\Repositories\Driver;

use App\Admin\Repositories\Driver\DriverRepository as AdminRepository;
use App\Api\V1\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\User\DiscountSortStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\User\CostStatus;
use App\Enums\User\RatingSortStatus;
use App\Enums\User\DistanceStatus;
use App\Enums\User\TimeStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Order\OrderType;
use App\Enums\Driver\AutoAccept;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use Throwable;



class DriverRepository extends AdminRepository implements DriverRepositoryInterface
{
    protected SettingRepositoryInterface $settingRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,

    ) {
        $this->settingRepository = $settingRepository;
        $this->model = new Driver();
    }

    protected function applyVerificationFilter($query, $isVerified): void
    {   
        $query->where('is_verified', VerificationStatus::Verified);
    }

    protected function haversineFormulaDriver($data): string
    {   
        return "(6371 * acos(cos(radians({$data['start_latitude']}))
               * cos(radians(drivers.current_lat))
               * cos(radians(drivers.current_lng) - radians({$data['start_longitude']}))
               + sin(radians({$data['start_latitude']}))
               * sin(radians(drivers.current_lat))))";
    }


    public function searchRideCar(array $data): LengthAwarePaginator
    {
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        $query = $this->model->newQuery();
        $this->applyVerificationFilter($query, $data['is_verified'] ?? null);

        $query->where('drivers.auto_accept', AutoAccept::Auto);

        $haversineDriver = $this->haversineFormulaDriver($data);

        $calculateDistanceUsingGoogleAPI = calculateDistanceGoogleAPI($data['start_latitude'], $data['start_longitude'], $data['end_lat'], $data['end_lng']);

        $query->select(DB::raw("
        drivers.id,
        drivers.user_id,
        drivers.booking_price,
        drivers.service_car_price,
        drivers.service_ride_price,
        drivers.service_delivery_now_price,
        drivers.delivery_later_fee_per_stop,
        drivers.service_intercity_price,
        drivers.current_address,
        drivers.current_lat,
        drivers.current_lng,
        MAX(vehicles.production_year) as production_year,
        COALESCE(AVG(reviews.rating), 0) as average_rating,
        COUNT(DISTINCT discounts.id) as active_discount_count,
        {$haversineDriver} AS distance_driver_to_user ,
        {$calculateDistanceUsingGoogleAPI} AS calculateDistanceUsingGoogleAPI
        "))

            ->leftJoin('vehicles', function ($join) {
                $join->on('drivers.id', '=', 'vehicles.driver_id');
            })
            ->leftJoin('reviews', 'drivers.id', '=', 'reviews.driver_id')
            ->leftJoin('discount_applications', 'drivers.id', '=', 'discount_applications.driver_id')

            ->leftJoin('discounts', function ($join) {
                $join->on('discount_applications.discount_code_id', '=', 'discounts.id')
                    ->where('discounts.status', DiscountStatus::Published);
            })
            ->groupBy(
                'drivers.id',
                'drivers.user_id',
                'drivers.booking_price',
                'drivers.service_car_price',
                'drivers.service_ride_price',
                'drivers.service_delivery_now_price',
                'drivers.delivery_later_fee_per_stop',
                'drivers.service_intercity_price',
                'drivers.current_address',
                'drivers.current_lat',
                'drivers.current_lng'
            );

        $query->where(function ($serviceQuery) use ($data) {
            switch ($data['order_type']) {
                case OrderType::C_RIDE->value:
                    $serviceQuery->where('drivers.service_ride', true)
                            ->where('drivers.service_ride_price','>' , 0);
                    break;

                case OrderType::C_CAR->value:
                    $serviceQuery->where('drivers.service_car', true)
                            ->where('drivers.service_car_price','>' , 0);
                    break;

                case OrderType::C_Delivery->value:
                    $serviceQuery->where('drivers.service_delivery_now', true)
                        ->orWhere('drivers.service_delivery_later', true)
                        ->where('drivers.service_delivery_now_price','>' , 0)
                        ->where('drivers.later_fee_per_stop','>' , 0);
                    break;

                case OrderType::C_Intercity->value:
                    $serviceQuery->where('drivers.service_intercity', true)
                                ->where('drivers.service_intercity_price', true);
                    break;

                case OrderType::C_Multi->value:
                    $serviceQuery->where('drivers.service_delivery_later', true)
                                ->where('drivers.later_fee_per_stop','>' , 0);
                    break;
            }
        });


        if (isset($data['cost_preference']) && !empty($data['cost_preference'])) {
            $order = $data['cost_preference'] === CostStatus::Lowest->value ? 'asc' : 'desc';
            $query->orderByRaw("booking_price {$order}");
        }

        if (isset($data['vehicles']) && !empty($data['vehicles'])) {
            $order = $data['vehicles'] === TimeStatus::Newest->value ? 'desc' : 'asc';
            $query->orderByRaw("CASE WHEN MAX(vehicles.production_year) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('production_year', $order);
        }

        if (isset($data['review']) && !empty($data['review'])) {
            $order = $data['review'] === RatingSortStatus::Highest->value ? 'desc' : 'asc';

            $query->orderByRaw("CASE WHEN COUNT(reviews.rating) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('average_rating', $order);
        }

        if (isset($data['discount']) && !empty($data['discount'])) {
            $order = $data['discount'] === DiscountSortStatus::Most->value ? 'desc' : 'asc';

            $query->orderByRaw("CASE WHEN COUNT(discount_applications.id) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('active_discount_count', $order);
        }

        if (isset($data['distance']) && isset($data['start_latitude']) && isset($data['start_longitude'])) {
            $haversineDriver = $this->haversineFormulaDriver($data);
            $order = $data['distance'] === DistanceStatus::Nearest->value ? 'asc' : 'desc';
            $query->orderByRaw("{$haversineDriver} {$order}");
        }

        if (isset($data['type']) && !empty($data['type'])) {
            $query->whereHas('vehicles', function ($vehicleQuery) use ($data) {
                $vehicleQuery->where('type', $data['type']);
            });
        }

        if (isset($data['price_setting']) && !empty($data['price_setting'])) {
            $haversine =  $calculateDistanceUsingGoogleAPI;
            $total_price_setting = floatval($data['price_setting']);
            $query->havingRaw("drivers.booking_price * ($haversine) <= ?", [$total_price_setting]);
            $query->orderBy('drivers.booking_price', 'asc');
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function searchByDeliveryAndMulti(array $data): LengthAwarePaginator
    {
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        $query = $this->model->newQuery();

        $this->applyVerificationFilter($query, $data['is_verified'] ?? null);

        $calculateDistanceUsingGoogleAPI = calculateDistanceGoogleAPI($data['start_latitude'], $data['start_longitude'], $data['end_lat'], $data['end_lng']);

        $query->select(DB::raw("
        drivers.id,
        drivers.user_id,
        drivers.booking_price,
        drivers.service_delivery_now_price,
        drivers.delivery_later_fee_per_stop,
        drivers.current_address,
        drivers.current_lat,
        drivers.current_lng,
        MAX(vehicles.production_year) as production_year,
        COALESCE(AVG(reviews.rating), 0) as average_rating,
        COUNT(DISTINCT discounts.id) as active_discount_count,
        {$calculateDistanceUsingGoogleAPI} AS calculateDistanceUsingGoogleAPI "))
            ->leftJoin('vehicles', function ($join) {
                $join->on('drivers.id', '=', 'vehicles.driver_id');
            })
            ->leftJoin('reviews', 'drivers.id', '=', 'reviews.driver_id')
            ->leftJoin('discount_applications', 'drivers.id', '=', 'discount_applications.driver_id')
            ->leftJoin('discounts', function ($join) {
                $join->on('discount_applications.discount_code_id', '=', 'discounts.id')
                    ->where('discounts.status', DiscountStatus::Published);
            })
            ->groupBy(
                'drivers.id',
                'drivers.user_id',
                'drivers.booking_price',
                'drivers.service_delivery_now_price',
                'drivers.delivery_later_fee_per_stop',
                'drivers.current_address',
                'drivers.current_lat',
                'drivers.current_lng'
            );

        $query->where(function ($serviceQuery) {
            $serviceQuery->where(function ($q) {
                $q->where('drivers.service_delivery_now', true)
                  ->where('drivers.service_delivery_now_price', '>', 0);
            })
            ->orWhere(function ($q) {
                $q->where('drivers.service_delivery_later', true)
                ->where('drivers.delivery_later_fee_per_stop', '>', 0);
            });
        });

        if (isset($data['cost_preference']) && !empty($data['cost_preference'])) {
            $order = $data['cost_preference'] === CostStatus::Lowest->value ? 'asc' : 'desc';
            $query->orderByRaw("booking_price {$order}");
        }
        if (isset($data['vehicles']) && !empty($data['vehicles'])) {
            $order = $data['vehicles'] === TimeStatus::Newest->value ? 'desc' : 'asc';
            $query->orderByRaw("CASE WHEN MAX(vehicles.production_year) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('production_year', $order);
        }
        if (isset($data['review']) && !empty($data['review'])) {
            $order = $data['review'] === RatingSortStatus::Highest->value ? 'desc' : 'asc';

            $query->orderByRaw("CASE WHEN COUNT(reviews.rating) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('average_rating', $order);
        }
        if (isset($data['discount']) && !empty($data['discount'])) {
            $order = $data['discount'] === DiscountSortStatus::Most->value ? 'desc' : 'asc';

            $query->orderByRaw("CASE WHEN COUNT(discount_applications.id) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('active_discount_count', $order);
        }

        if (isset($data['price_setting']) && !empty($data['price_setting'])) {
            $haversine =  $calculateDistanceUsingGoogleAPI;

            $total_price_setting = floatval($data['price_setting']);

            $query->havingRaw("drivers.booking_price * ($haversine) <= ?", [$total_price_setting]);
            $query->orderBy('drivers.booking_price', 'asc');
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function searchIntercity(array $data): LengthAwarePaginator
    {
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        $query = $this->model->newQuery();
        
        $this->applyVerificationFilter($query, $data['is_verified'] ?? null);

        $query->select(DB::raw("
        drivers.id,
        drivers.user_id,
        drivers.booking_price,
        drivers.current_address,
        drivers.service_intercity_price,
        drivers.current_lat,
        drivers.current_lng,
        MAX(vehicles.production_year) as production_year,
        COALESCE(AVG(reviews.rating), 0) as average_rating,
         COUNT(DISTINCT discounts.id) as active_discount_count "))

            ->leftJoin('vehicles', function ($join) {
                $join->on('drivers.id', '=', 'vehicles.driver_id');
            })
            ->leftJoin('reviews', 'drivers.id', '=', 'reviews.driver_id')
            ->leftJoin('discount_applications', 'drivers.id', '=', 'discount_applications.driver_id')
            ->leftJoin('discounts', function ($join) {
                $join->on('discount_applications.discount_code_id', '=', 'discounts.id')
                    ->where('discounts.status', DiscountStatus::Published);
            })
            ->groupBy(
                'drivers.id',
                'drivers.user_id',
                'drivers.booking_price',
                'drivers.service_intercity_price',
                'drivers.current_address',
                'drivers.current_lat',
                'drivers.current_lng'
            );
        $query->where(function ($serviceQuery) {
            $serviceQuery->where('drivers.service_intercity', true)
                            ->where('drivers.service_intercity_price','>',0);;
        });

        if (isset($data['cost_preference']) && !empty($data['cost_preference'])) {
            $order = $data['cost_preference'] === CostStatus::Lowest->value ? 'asc' : 'desc';
            $query->orderByRaw("booking_price {$order}");
        }
        if (isset($data['vehicles']) && !empty($data['vehicles'])) {
            $order = $data['vehicles'] === TimeStatus::Newest->value ? 'desc' : 'asc';
            $query->orderByRaw("CASE WHEN MAX(vehicles.production_year) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('production_year', $order);
        }
        if (isset($data['review']) && !empty($data['review'])) {
            $order = $data['review'] === RatingSortStatus::Highest->value ? 'desc' : 'asc';
            $query->orderByRaw("CASE WHEN COUNT(reviews.rating) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('average_rating', $order);
        }
        if (isset($data['discount']) && !empty($data['discount'])) {
            $order = $data['discount'] === DiscountSortStatus::Most->value ? 'desc' : 'asc';
            $query->orderByRaw("CASE WHEN COUNT(discount_applications.id) = 0 THEN 1 ELSE 0 END ASC");
            $query->orderBy('active_discount_count', $order);
        }
        if (isset($data['type']) && !empty($data['type'])) {
            $query->whereHas('vehicles', function ($vehicleQuery) use ($data) {
                $vehicleQuery->whereIn('type', [VehicleType::Car4, VehicleType::Car7]);
            });
        }   
    
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}

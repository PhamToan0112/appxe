<?php

namespace App\Admin\Services\Calculation;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Holiday\HolidayRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Api\V1\Exception\NotFoundException;
use App\Api\V1\Http\Resources\Order\CRideCar\OrderCRideCarResource;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Route\RouteRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Area\AreaStatus;
use App\Enums\DefaultStatus;
use App\Enums\Discount\DiscountType;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\TripType;
use App\Enums\Vehicle\SettingSwitchStatus;
use App\Models\Driver;
use App\Models\DriverRateWeight;
use App\Traits\CalculationsTrait;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class CalculationServiceService implements CalculationServiceInterface
{
    use UseLog, CalculationsTrait,AuthServiceApi;

    protected OrderRepositoryInterface $orderRepository;

    protected DriverRepositoryInterface $driverRepository;
    protected SettingRepositoryInterface $settingRepository;
    protected DiscountRepositoryInterface $discountRepository;
    protected HolidayRepositoryInterface $holidayRepository;

    protected WeightRangeRepositoryInterface $weightRangeRepository;
    protected ShipmentRepositoryInterface $shipmentRepository;
    protected RouteRepositoryInterface $routeRepository;
    protected RouteVariantRepositoryInterface $routeVariantRepository;


    public function __construct(OrderRepositoryInterface        $orderRepository,
                                SettingRepositoryInterface      $settingRepository,
                                DiscountRepositoryInterface     $discountRepository,
                                HolidayRepositoryInterface      $holidayRepository,
                                WeightRangeRepositoryInterface  $weightRangeRepository,
                                ShipmentRepositoryInterface     $shipmentRepository,
                                RouteRepositoryInterface        $routeRepository,
                                RouteVariantRepositoryInterface $routeVariantRepository,
                                DriverRepositoryInterface       $driverRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->driverRepository = $driverRepository;
        $this->settingRepository = $settingRepository;
        $this->discountRepository = $discountRepository;
        $this->holidayRepository = $holidayRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->routeRepository = $routeRepository;
        $this->routeVariantRepository = $routeVariantRepository;
        $this->weightRangeRepository = $weightRangeRepository;

    }


    /**
     * @throws Exception
     */
    public function calculateBookCarOrder(Request $request): array|bool
    {
        try {
            $data = $request->validated();
            $startLat = $data['start_latitude'];
            $startLng = $data['start_longitude'];
            $endLat = $data['end_latitude'];
            $endLng = $data['end_longitude'];
            $driverId = $data['driver_id'] ?? null;
            $discountId = $data['discount_id'] ?? null;
            $orderType = $data['order_type'];
            $distance = $this->calculateDistance($startLat, $startLng, $endLat, $endLng);
            if (!$driverId) {
                return $this->calculateNotDriver($distance);
            }

            $driver = $this->driverRepository->findOrFail($driverId);
            $subTotal = $this->calculateSubTotal($distance, $driver, $orderType, $data);
            $peakHourFee = $this->calculatePeakHourFeeCRideCar($driver, $orderType);
            $discountAmount = $this->calculateDiscount($discountId, $subTotal);
            $platformFee = $this->calculatePlatformFeeCRideCar($subTotal, $distance, $orderType);
            $peakAreaFee = $this->calculateAreaFee($endLat, $endLng, $driver);
            $HolidayPrice = $this->calculateHolidayFee($driver);
            $total = $this->calculateTotal($subTotal, $platformFee, $discountAmount, $peakAreaFee,
                $HolidayPrice, $peakHourFee);
            return [
                'distance' => $distance,
                'sub_total' => $subTotal,
                'platform_fee' => $platformFee,
                'discount_amount' => $discountAmount,
                'peak_area_fee' => $peakAreaFee,
                'holiday_price' => $HolidayPrice,
                'peak_hour_fee' => $peakHourFee,
                'total' => $total

            ];
        } catch (Exception $e) {
            $this->logError("Unable to calculate Book car", $e);
            return false;
        }

    }

    /**
     * @throws Exception
     */
    public function calculateRideCarByDriver(Request $request): array|bool
    {
        $data = $request->validated();
        $driver = $this->getCurrentDriver();
        $orderType = $data['order_type'];
        $orderId = $data['id'];
        $order = $this->orderRepository->findOrFail($orderId);
        $shipment = $order->shipments->first();
        $startLat = $shipment->start_latitude;
        $startLng = $shipment->start_longitude;
        $endLat = $shipment->end_latitude;
        $endLng = $shipment->end_longitude;
        $distance = $this->calculateDistance($startLat, $startLng, $endLat, $endLng);
        $subTotal = $this->calculateSubTotal($distance, $driver, $orderType, $data);
        $peakHourFee = $this->calculatePeakHourFeeCRideCar($driver, $orderType);
        $discountAmount = 0;
        $platformFee = $this->calculatePlatformFeeCRideCar($subTotal, $distance, $orderType);
        $peakAreaFee = $this->calculateAreaFee($endLat, $endLng, $driver);
        $HolidayPrice = $this->calculateHolidayFee($driver);
        $total = $this->calculateTotal($subTotal, $platformFee, $discountAmount, $peakAreaFee,
            $HolidayPrice, $peakHourFee);


        return [
            'distance' => $distance,
            'sub_total' => $subTotal,
            'platform_fee' => $platformFee,
            'discount_amount' => $discountAmount,
            'peak_area_fee' => $peakAreaFee,
            'holiday_price' => $HolidayPrice,
            'peak_hour_fee' => $peakHourFee,
            'total' => $total,
            'order' => new OrderCRideCarResource($order)

        ];

    }

    public function calculateCDeliveryOrder(Request $request): bool|array
    {
        try {
            $data = $request->validated();
            $startLat = $data['start_latitude'];
            $startLng = $data['start_longitude'];
            $endLat = $data['end_latitude'];
            $endLng = $data['end_longitude'];
            $driverId = $data['driver_id'] ?? null;
            $discountId = $data['discount_id'] ?? null;
            $orderType = OrderType::C_Delivery->value;
            $distance = $this->calculateDistance($startLat, $startLng, $endLat, $endLng);
            if (!$driverId) {
                return $this->calculateNotDriver($distance);
            }

            $driver = $this->driverRepository->findOrFail($driverId);
            $subTotal = $this->calculateSubTotal($distance, $driver, $orderType, $data);
            $discountAmount = $this->calculateDiscount($discountId, $subTotal);
            $platformFee = $this->calculatePlatformFeeCDelivery($subTotal);
            $peakAreaFee = $this->calculateAreaFee($endLat, $endLng, $driver);
            $peakHourFee = $this->calculatePeakHourFeeCDelivery($driver);
            $HolidayPrice = $this->calculateHolidayFee($driver);
            $codAmount = $this->calculateCODAmountCDelivery($data);
            $advancePaymentAmount = $this->calculateAdvancePaymentAmountCDelivery($subTotal, $codAmount, $data);
            $total = $this->calculateTotal($subTotal, $platformFee, $discountAmount,
                    $peakAreaFee, $HolidayPrice, $peakHourFee) + $advancePaymentAmount - $codAmount;

            return [
                'distance' => $distance,
                'sub_total' => $subTotal,
                'platform_fee' => $platformFee,
                'discount_amount' => $discountAmount,
                'peak_area_fee' => $peakAreaFee,
                'peak_hour_fee' => $peakHourFee,
                'holiday_price' => $HolidayPrice,
                'cod_amount' => $codAmount,
                'advance_payment_amount' => $advancePaymentAmount,
                'total' => $total

            ];
        } catch (Exception $e) {
            $this->logError("Unable to calculate Book car", $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function calculateCMultiOrder(Request $request): array
    {
        $data = $request->validated();
        $shipmentIds = $data['shipment_ids'] ?? [];
        $driverId = $data['driver_id'] ?? null;
        $discountId = $data['discount_id'] ?? null;
        $orderType = OrderType::C_Multi->value;
        $distance = $this->calculateTotalDistanceShipments($shipmentIds);
        if (!$driverId) {
            return $this->calculateNotDriver($distance);
        }
        $driver = $this->driverRepository->findOrFail($driverId);
        $pricePerStop = count($shipmentIds) * (float)$driver->delivery_later_fee_per_stop;
        $subTotal = $this->calculateSubTotal($distance, $driver, $orderType, $data);
        $discountAmount = $this->calculateDiscount($discountId, $subTotal);
        $platformFee = $this->calculatePlatformFeeCMulti($subTotal);
        $peakAreaFee = 0;
        $HolidayPrice = $this->calculateHolidayFee($driver);
        $peakHourFee = $this->calculatePeakHourFeeCMulti($driver);
        $nightFee = $this->calculateNightFee($driver);
        $codAmount = $this->calculateCODAmountCMulti($data);
        $advancePaymentAmount = $this->checkShipmentCollectionFromSenderStatus($shipmentIds) ?
            abs($codAmount - $subTotal) : 0;


        $total = $this->calculateTotal($subTotal, $platformFee, $discountAmount,
                $peakAreaFee, $HolidayPrice, $peakHourFee, $nightFee) + $advancePaymentAmount - $codAmount;

        return [
            'distance' => $distance,
            'price_per_stop' => $pricePerStop,
            'sub_total' => $subTotal,
            'platform_fee' => $platformFee,
            'discount_amount' => $discountAmount,
            'holiday_price' => $HolidayPrice,
            'peak_hour_fee' => $peakHourFee,
            'night_fee' => $nightFee,
            'cod_amount' => $codAmount,
            'advance_payment_amount' => $advancePaymentAmount,
            'total' => $total
        ];

    }

    /**
     * @throws Exception
     */
    public function calculateCIntercityOrder(Request $request): array
    {
        $data = $request->validated();
        $driverId = $data['driver_id'] ?? null;
        $discountId = $data['discount_id'] ?? null;
        $routeId = $data['route_variant_id'];
        $quantity = $data['passenger_count'];
        $tripType = $data['trip_type'];
        if (!$driverId) {
            return $this->calculateNotDriver(0);
        }
        $driver = $this->driverRepository->findOrFail($driverId);
        $subTotal = $this->calculateSubTotalCIntercity($routeId, $quantity, $tripType, $driver);
        $discountAmount = $this->calculateDiscount($discountId, $subTotal);
        $platformFee = $this->calculatePlatformFeeCIntercity($subTotal);
        $HolidayPrice = $this->calculateHolidayFee($driver);
        $peakHourFee = $this->calculatePeakHourFeeCIntercity($driver);
        $peakAreaFee = 0;
        $nightFee = $this->calculateNightFeeCIntercity($routeId, $driver);
        $total = $this->calculateTotal($subTotal, $platformFee, $discountAmount,
            $peakAreaFee, $HolidayPrice, $peakHourFee, $nightFee);

        return [
            'sub_total' => $subTotal,
            'platform_fee' => $platformFee,
            'discount_amount' => $discountAmount,
            'holiday_price' => $HolidayPrice,
            'peak_hour_fee' => $peakHourFee,
            'night_fee' => $nightFee,
            'total' => $total
        ];
    }

    public function calculateAdvancePaymentAmountCDelivery($subTotal, $codAmount, $data): float|int
    {
        if ($data['collection_from_sender_status'] == OpenStatus::ON->value) {
            return abs($codAmount - $subTotal);
        }
        return 0;
    }

    /**
     * @throws Exception
     */

    /**
     * @throws Exception
     */
    public function checkShipmentCollectionFromSenderStatus($shipmentIds): bool
    {
        $result = false;
        foreach ($shipmentIds as $value) {
            $shipment = $this->shipmentRepository->find($value);
            if ($shipment && $shipment->collection_from_sender_status == OpenStatus::ON) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function calculateCODAmountCMulti($data)
    {
        $shipmentIds = $data['shipment_ids'] ?? [];
        $codAmount = 0;

        foreach ($shipmentIds as $value) {
            $shipment = $this->shipmentRepository->find($value);
            if ($shipment && $shipment->collection_from_sender_status == OpenStatus::ON) {
                $codAmount += $shipment->collect_on_delivery_amount ?? 0;
            }
        }

        return $codAmount;
    }

    public function calculateCODAmountCDelivery($data)
    {
        $result = 0;
        if ($data['collection_from_sender_status'] == OpenStatus::ON->value) {
            return $data['advance_payment_amount'] ?? 0;
        }
        return $result;

    }


    /**
     * Calculate the peak hour fee based on the current time and predefined peak hours.
     *
     * @param Driver $driver The driver's information, including peak hour pricing.
     * @param $orderType
     * @return float The additional peak hour fee.
     */
    public function calculatePeakHourFeeCRideCar(Driver $driver, $orderType): float
    {
        $currentTime = Carbon::now();

        if ($orderType == OrderType::C_RIDE->value) {
            $morningStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Ride_morning_start'));
            $morningEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Ride_morning_end'));
            $afternoonStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Ride_afternoon_start'));
            $afternoonEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Ride_afternoon_end'));
        } else {
            $morningStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Car_morning_start'));
            $morningEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Car_morning_end'));
            $afternoonStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Car_afternoon_start'));
            $afternoonEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Car_afternoon_end'));
        }
        if ($currentTime->between($morningStart, $morningEnd) || $currentTime->between($afternoonStart, $afternoonEnd)) {
            return (float)$driver->peak_hour_price;
        } else {
            return 0.0;
        }

    }

    public function calculatePeakHourFeeCDelivery(Driver $driver): float
    {
        $currentTime = Carbon::now();
        $morningStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Delivery_morning_start'));
        $morningEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Delivery_morning_end'));
        $afternoonStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Delivery_afternoon_start'));
        $afternoonEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Delivery_afternoon_end'));
        if ($currentTime->between($morningStart, $morningEnd) || $currentTime->between($afternoonStart, $afternoonEnd)) {
            return (float)$driver->peak_hour_price;
        } else {
            return 0.0;
        }
    }

    public function calculatePeakHourFeeCIntercity(Driver $driver): float
    {
        $currentTime = Carbon::now();
        $morningStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Intercity_morning_start'));
        $morningEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Intercity_morning_end'));
        $afternoonStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Intercity_afternoon_start'));
        $afternoonEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Intercity_afternoon_end'));
        if ($currentTime->between($morningStart, $morningEnd) || $currentTime->between($afternoonStart, $afternoonEnd)) {
            return (float)$driver->peak_hour_price;
        } else {
            return 0.0;
        }
    }

    public function calculatePeakHourFeeCMulti(Driver $driver): float
    {
        $currentTime = Carbon::now();
        $morningStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Multi_morning_start'));
        $morningEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Multi_morning_end'));
        $afternoonStart = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Multi_afternoon_start'));
        $afternoonEnd = Carbon::createFromTimeString($this->settingRepository->getPlainValue('bike_C_Multi_afternoon_end'));
        if ($currentTime->between($morningStart, $morningEnd) || $currentTime->between($afternoonStart, $afternoonEnd)) {
            return (float)$driver->peak_hour_price;
        } else {
            return 0.0;
        }
    }

    /**
     * @throws Exception
     */
    public function calculateAreaFee($endLat, $endLng, $driver): float
    {
//        $area = $this->getArea($endLat, $endLng);
//        if ($area && $area->peak_status === AreaStatus::On) {
//            return (float)$driver->peak_hour_price;
//        }
        return 0.0;
    }

    public function calculateTotalDistanceShipments($shipmentIds): float|int
    {
        $distance = 0;
        foreach ($shipmentIds as $shipmentId) {
            $shipment = $this->shipmentRepository->find($shipmentId);
            $startLat = $shipment->start_latitude;
            $startLng = $shipment->start_longitude;
            $endLat = $shipment->end_latitude;
            $endLng = $shipment->end_longitude;
            $distance += $this->calculateDistance($startLat, $startLng, $endLat, $endLng);
        }
        return $distance;
    }


    /**
     * @throws Exception
     */
    public function calculateSubTotalCIntercity($routeId, $quantity, $tripType, $driver): float|int
    {
        $route = $this->routeVariantRepository->find($routeId);
        $price = $route->price ?? 0;

        return $price * $quantity;
    }

    /**
     * @throws Exception
     */
    public function calculateNightFeeCIntercity($routeId, Driver $driver): float
    {
        $route = $this->routeVariantRepository->find($routeId);
        $nightTimePrice = $driver->night_time_price ?? 0;
        $departureTime = Carbon::parse($route->departure_time);
        $nightStart = Carbon::createFromTime(23, 0, 0);
        $nightEnd = Carbon::createFromTime(6, 0, 0)->addDay();
        if ($departureTime->between($nightStart, $nightEnd)) {
            return $nightTimePrice;
        }
        return 0.0;
    }

    public function calculateNightFee(Driver $driver): float
    {
        $nightTimePrice = $driver->night_time_price ?? 0;
        $currentTime = Carbon::now();
        $nightStart = Carbon::createFromTime(23, 0, 0);
        $nightEnd = Carbon::createFromTime(6, 0, 0)->addDay();

        if ($nightEnd->lessThan($nightStart)) {
            $nightEnd->addDay();
        }

        if ($currentTime->between($nightStart, $nightEnd)) {
            return $nightTimePrice;
        }
        return 0.0;
    }


    public function calculateNotDriver($distance): array
    {
        return [
            'distance' => $distance,
            'sub_total' => 0,
            'platform_fee' => 0,
            'discount_amount' => 0,
            'total' => 0
        ];
    }

    public function calculateDistance(float $startLatitude, float $startLongitude, float $endLatitude, float $endLongitude): float
    {
        return calculateDistanceGoogleAPi($startLatitude, $startLongitude, $endLatitude, $endLongitude);
    }


    public function calculatePlatformFeeCRideCar(float $totalAmount, float $distance, ?string $orderType): float
    {
        $platformFeePercentage = 0;
        $enablePlatformFeeCRide = $this->settingRepository
            ->getPlainValue('enable_platform_fee_C_Ride');
        $enablePlatformFeeCCar = $this->settingRepository
            ->getPlainValue('enable_platform_fee_C_Car');

        if ($orderType == OrderType::C_CAR->value &&
            $enablePlatformFeeCCar == SettingSwitchStatus::OPEN->value) {
            $platformFeePercentage = $this->settingRepository
                ->getPlainValue('platform_fee_C_Car');
        }

        if ($orderType == OrderType::C_RIDE->value &&
            $enablePlatformFeeCRide == SettingSwitchStatus::OPEN->value) {
            $platformFeePercentage = $this->settingRepository
                ->getPlainValue('platform_fee_C_Ride');
        }
        return ($totalAmount * ($platformFeePercentage / 100));

    }

    public function calculatePlatformFeeCDelivery(float $totalAmount): float
    {
        $enablePlatformFeeCDelivery = $this->settingRepository
            ->getPlainValue('enable_platform_fee_C_Delivery');
        if ($enablePlatformFeeCDelivery == SettingSwitchStatus::OPEN->value) {
            $platformFeePercentage = (int)$this->settingRepository
                ->getPlainValue('platform_fee_C_Delivery');
        } else {
            $platformFeePercentage = 0;
        }

        return ($totalAmount * ($platformFeePercentage / 100));

    }

    public function calculatePlatformFeeCMulti(float $totalAmount): float
    {
        $enablePlatformFeeCMulti = $this->settingRepository
            ->getPlainValue('enable_platform_fee_C_multi');
        if ($enablePlatformFeeCMulti == SettingSwitchStatus::OPEN->value) {
            $platformFeePercentage = (int)$this->settingRepository
                ->getPlainValue('platform_fee_C_Multi');
        } else {
            $platformFeePercentage = 0;
        }

        return ($totalAmount * ($platformFeePercentage / 100));

    }

    public function calculatePlatformFeeCIntercity(float $totalAmount): float
    {
        $enablePlatformFeeCMulti = $this->settingRepository
            ->getPlainValue('enable_platform_fee_C_intercity');
        if ($enablePlatformFeeCMulti == SettingSwitchStatus::OPEN->value) {
            $platformFeePercentage = (int)$this->settingRepository
                ->getPlainValue('platform_fee_C_Intercity');
        } else {
            $platformFeePercentage = 0;
        }

        return ($totalAmount * ($platformFeePercentage / 100));

    }

    /**
     * @throws Exception
     */
    public function calculateSubTotal(float   $distance, $driver,
                                      ?string $orderType = null,
                                      array   $data): float
    {
        $bookingPrice = 0;
        $rangeFee = 0;
        $pricePerStop = 0;

        switch ($orderType) {
            case OrderType::C_CAR->value:
                $bookingPrice = (float)$driver->service_car_price;
                break;
            case OrderType::C_RIDE->value:
                $bookingPrice = (float)$driver->service_ride_price;
                break;
            case OrderType::C_Delivery->value:
                $bookingPrice = (float)$driver->service_delivery_now_price;
                $rangeFee = $this->handleCalculatePriceForWeightRange($driver, $data);
                break;
            case OrderType::C_Multi->value:
                $shipmentIds = $data['shipment_ids'] ?? [];
                $bookingPrice = (float)$driver->service_delivery_now_price;
                $rangeFee = $this->handleCalculatePriceForWeightRangeCMulti($driver, $data);
                $pricePerStop = count($shipmentIds) * (float)$driver->delivery_later_fee_per_stop;
                break;
            case OrderType::C_Intercity->value:
                $bookingPrice = (float)$driver->service_intercity_price;
                break;
            default:
                break;
        }

        return ($distance * $bookingPrice) + $rangeFee + $pricePerStop;
    }

    public function handleCalculatePriceForWeightRange($driver, array $data): float
    {
        $weightRangeId = $data['weight_range_id'];
        return $this->getPriceForWeightRange($driver->id, $weightRangeId);
    }

    /**
     * @throws Exception
     */
    public function handleCalculatePriceForWeightRangeCMulti($driver, array $data): float|int|null
    {
        $shipmentIds = $data['shipment_ids'] ?? [];
        $totalRangeFee = 0;

        foreach ($shipmentIds as $shipmentId) {
            $shipment = $this->shipmentRepository->find($shipmentId);
            $totalRangeFee += $this->getPriceForWeightRange($driver->id, $shipment->weight_range_id);
        }
        return $totalRangeFee;
    }


    /**
     * @throws Exception
     */
    public function calculateDiscount(string $discountId = null, $subTotal): float
    {
        $discount = $this->discountRepository->find($discountId);

        if (!$discount) {
            return 0;
        }
        if ($discount->type === DiscountType::Money) {
            $discountAmount = $discount->discount_value;
        } else {
            $percent = $discount->percent_value / 100;
            $discountAmount = ($subTotal * $percent);
        }

        return $discountAmount;
    }

    public function getPriceForWeightRange(int $driverId, int $weightRangeId): ?float
    {
        $rateWeight = DriverRateWeight::where('driver_id', $driverId)
            ->where('shipping_weight_range_id', $weightRangeId)
            ->first();

        return $rateWeight ? (float)$rateWeight->price : null;
    }


    public function calculateTotal(float $subTotal, float $platformFee,
                                   float $discount = 0, float $peakAreaFee = 0,
                                   float $HolidayPrice = 0, $peakHourFee = 0, $nightFee = 0): float
    {
        $total = ($subTotal + $platformFee) + $peakAreaFee + $HolidayPrice + $peakHourFee + $nightFee - $discount;

        return max($total, 0);
    }


    public function calculateHolidayFee(Driver $driver): float
    {
        $today = now()->format('Y-m-d');
        $holidays = $this->holidayRepository->getBy(['status' => DefaultStatus::Published]);
        foreach ($holidays as $holiday) {
            if ($holiday->date == $today) {
                return (float)$driver->holiday_price ?? 0;
            }
        }
        return 0;
    }


    public function getCostByDistanceCRide(float $distance): float
    {
        $baseDistance = (float)$this->settingRepository->getPlainValue('bike_C_Ride_base_distance');
        $baseFare = (float)$this->settingRepository->getPlainValue('bike_C_Ride_base_fare');
        $distanceToDiscount = (float)$this->settingRepository->getPlainValue('bike_C_Ride_distance_to_discount');
        $ratePerKm = (float)$this->settingRepository->getPlainValue('bike_C_Ride_rate_per_km');
        $ratePerKmDiscount = (float)$this->settingRepository->getPlainValue('bike_C_Ride_rate_per_km_discount');

        return $this->calculateTransportFee($distance, $baseDistance, $baseFare, $distanceToDiscount, $ratePerKm, $ratePerKmDiscount);

    }


    public function getCostByDistanceCCar(float $distance): float
    {
        $baseDistance = (float)$this->settingRepository->getPlainValue('bike_C_Car_base_distance');
        $baseFare = (float)$this->settingRepository->getPlainValue('bike_C_Car_base_fare');
        $distanceToDiscount = (float)$this->settingRepository->getPlainValue('bike_C_Car_distance_to_discount');
        $ratePerKm = (float)$this->settingRepository->getPlainValue('bike_C_Car_rate_per_km');
        $ratePerKmDiscount = (float)$this->settingRepository->getPlainValue('bike_C_Car_rate_per_km_discount');

        return $this->calculateTransportFee($distance, $baseDistance, $baseFare, $distanceToDiscount, $ratePerKm, $ratePerKmDiscount);

    }

    public function calculateTransportFee(float $distance, float $baseDistance, float $baseFare, float $distanceToDiscount, float $ratePerKm, float $ratePerKmDiscount): float
    {
        if ($distance <= $baseDistance) {
            return $baseFare * $distance;
        } elseif ($distance <= $distanceToDiscount) {
            return ($baseDistance * $baseFare) + (($distance - $baseDistance) * $ratePerKm);
        } else {
            return ($baseDistance * $baseFare) +
                (($distanceToDiscount - $baseDistance) * $ratePerKm) +
                (($distance - $distanceToDiscount) * $ratePerKmDiscount);
        }
    }


}

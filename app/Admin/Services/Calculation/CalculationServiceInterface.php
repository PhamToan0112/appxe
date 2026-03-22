<?php

namespace App\Admin\Services\Calculation;

use App\Models\Driver;
use Illuminate\Http\Request;

interface CalculationServiceInterface
{
    public function calculateBookCarOrder(Request $request);

    public function calculateRideCarByDriver(Request $request);

    public function calculateCDeliveryOrder(Request $request);

    public function calculateCMultiOrder(Request $request);

    public function calculateCIntercityOrder(Request $request);


    public function calculateDistance(float $startLatitude, float $startLongitude, float $endLatitude, float $endLongitude): float;



    /**
     * Calculate the platform fee based on the total order amount and the distance of the ride.
     *
     * @param float $totalAmount The total amount of the order.
     * @param float $distance The distance of the ride.
     * @param string|null $orderType The type of the ride, e.g., 'C_Ride' or 'C_Car'.
     * @return float The calculated platform fee.
     */
    public function calculatePlatformFeeCRideCar(float $totalAmount, float $distance, ?string $orderType): float;


    /**
     * Calculate the discount amount based on the discount type and value.
     *
     * @param string $discountId
     * @param $subTotal
     * @return float The total amount after applying the discount.
     */
    public function calculateDiscount(string $discountId, $subTotal): float;

    /**
     * Calculate additional holiday fee based on the booking date.
     *
     * @param Driver $driver
     * @return float The additional holiday fee.
     */
    public function calculateHolidayFee(Driver $driver): float;

    /**
     * Calculate the total amount including the platform fee.
     *
     * @param float $subTotal The subtotal amount.
     * @param float $platformFee The platform fee.
     * @return float The calculated total amount.
     */
    public function calculateTotal(float $subTotal, float $platformFee,
                                   float $discount, float $peakAreaFee,
                                   float $HolidayPrice): float;
}

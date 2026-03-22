<?php

namespace App\Api\V1\Services\Discount;

use Illuminate\Http\Request;

interface DiscountServiceInterface
{
    public function findByUserOrDriver(Request $request);

    public function getDiscountByDriver(Request $request);

    public function checkDiscountByDriver(Request $request);

    public function isEligible($discount, float $subTotal): bool;

    public function driverStore(Request $request);

    public function driverUpdate(Request $request);

    public function driverDelete($id);

    public function getOptionDiscountCode(Request $request);
}

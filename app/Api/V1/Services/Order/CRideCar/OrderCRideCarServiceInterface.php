<?php

namespace App\Api\V1\Services\Order\CRideCar;

use Illuminate\Http\Request;

interface OrderCRideCarServiceInterface
{
    public function createBookOrder(Request $request);

    public function update(Request $request);

    public function driverSelectOrder(Request $request);

}

<?php

namespace App\Api\V1\Services\Order\CDelivery;

use Illuminate\Http\Request;

interface OrderCDeliveryServiceInterface
{
    public function createDeliveryOrder(Request $request);

}

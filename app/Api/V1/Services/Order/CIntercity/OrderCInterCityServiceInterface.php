<?php

namespace App\Api\V1\Services\Order\CIntercity;

use Illuminate\Http\Request;

interface OrderCInterCityServiceInterface
{
    public function createCIntercityOrder(Request $request);

}

<?php

namespace App\Admin\Services\Order;

use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function updateCRideCar(Request $request);

    public function updateCDelivery(Request $request);

    public function updateCMulti(Request $request);
    public function updateCIntercity(Request $request);

}

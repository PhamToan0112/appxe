<?php

namespace App\Api\V1\Services\Order\CMulti;

use Illuminate\Http\Request;

interface OrderCMultiServiceInterface
{
    public function createCMultiOrder(Request $request);
    public function completeShipment(Request $request);
    public function updateShipmentStatusToPreparing(Request $request);
    public function updateMultiPointOrderDetailStatus(Request $request);
    public function getShipments(Request $request);

}

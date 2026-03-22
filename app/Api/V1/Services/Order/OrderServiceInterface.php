<?php

namespace App\Api\V1\Services\Order;

use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function delete($id);

    public function checkCreateOrder(Request $request);

    public function updateStatus(Request $request);

    public function assignDriverToOrder(Request $request);

    public function selectCustomerForOrder(Request $request);

    public function uploadOrderConfirmationImage(Request $request);

    public function getOrderByUser(Request $request);

    public function getOrderActive(Request $request);

    public function getOrdersWithoutDriver(Request $request);

    public function updateLocation(Request $request);

}

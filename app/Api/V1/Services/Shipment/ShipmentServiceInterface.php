<?php

namespace App\Api\V1\Services\Shipment;

use Illuminate\Http\Request;

interface ShipmentServiceInterface
{
    public function store(Request $request);

    public function delete(Request $request);
}
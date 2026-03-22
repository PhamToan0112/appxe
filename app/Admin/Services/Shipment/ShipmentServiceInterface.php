<?php

namespace App\Admin\Services\Shipment;

use Illuminate\Http\Request;

interface ShipmentServiceInterface
{
    public function delete(int $id): mixed;

    public function update(Request $request);
}
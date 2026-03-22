<?php

namespace App\Api\V1\Repositories\Vehicle;
use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Http\Request;

interface VehicleRepositoryInterface extends EloquentRepositoryInterface
{
    public function store(array $data);
    public function getVehicleByDriver($driverId);
    public function searchVehicle(Request $request);
}

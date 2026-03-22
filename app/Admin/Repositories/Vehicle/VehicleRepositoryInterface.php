<?php

namespace App\Admin\Repositories\Vehicle;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface VehicleRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
    public function getVehicleLine();

    public function check_service_type(string $serviceType): bool;
}

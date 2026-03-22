<?php

namespace App\Admin\Repositories\Vehicle;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Enums\Vehicle\VehicleStatus;
use App\Models\Vehicle;
use App\Models\VehicleLines;

class VehicleRepository extends EloquentRepository implements VehicleRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return Vehicle::class;
    }

    public function getVehicleLine(){
        return VehicleLines::where('status',1)->get();
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {
        $this->instance = $this->model->where('status', '=', VehicleStatus::Pending)
            ->where('name', 'like', '%' . $keySearch . '%')
            ->whereDoesntHave('driver');

        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }

    public function check_service_type(string $serviceType): bool
    {
        $exists = $this->model->where('service_type', $serviceType)->exists();  
        return $exists;
    }
}

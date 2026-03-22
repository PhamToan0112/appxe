<?php
namespace App\Admin\Repositories\VehicleLines;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface;
use App\Enums\DefaultStatus;
use App\Models\VehicleLines;    

class VehicleLinesRepository extends EloquentRepository implements VehicleLinesRepositoryInterface{
    protected $select = [];
    public function getModel(): string{
        return VehicleLines::class;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10){
        $this->instance = $this->model->where('status', '=', DefaultStatus::Published)
            ->where('name', 'like', '%' . $keySearch . '%');
        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }
}

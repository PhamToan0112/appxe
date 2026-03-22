<?php
namespace   App\Admin\Repositories\VehicleLines;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface VehicleLinesRepositoryInterface extends EloquentRepositoryInterface{
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
}
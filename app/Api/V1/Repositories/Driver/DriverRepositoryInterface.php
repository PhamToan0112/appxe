<?php

namespace App\Api\V1\Repositories\Driver;

use App\Admin\Repositories\EloquentRepositoryInterface;
use Illuminate\Http\Request;

interface DriverRepositoryInterface extends EloquentRepositoryInterface
{

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    // public function getDriverInfo(array $data);

    public function searchRideCar(array $data);
    
    public function searchByDeliveryAndMulti(array $data);

    public function searchIntercity(array $data);

}

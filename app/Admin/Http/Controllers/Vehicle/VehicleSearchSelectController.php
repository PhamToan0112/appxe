<?php

namespace App\Admin\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Http\Resources\Vehicle\VehicleSearchSelectResource;

class VehicleSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        VehicleRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse()
    {
        $this->instance = [
            'results' => VehicleSearchSelectResource::collection($this->instance)
        ];
    }
}

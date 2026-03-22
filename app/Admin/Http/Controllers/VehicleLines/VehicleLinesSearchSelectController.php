<?php

namespace App\Admin\Http\Controllers\VehicleLines;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\VehicleLines\VehicleLinesSearchSelectResource;
use App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface;

class VehicleLinesSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        VehicleLinesRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => VehicleLinesSearchSelectResource::collection($this->instance)
        ];
    }
}

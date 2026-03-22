<?php

namespace App\Admin\Http\Controllers\Driver;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\Driver\DriverSearchSelectResource;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;

class DriverSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        DriverRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(){
        $this->instance = [
            'results' => DriverSearchSelectResource::collection($this->instance)
        ];
    }
}

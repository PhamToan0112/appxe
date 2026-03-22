<?php

namespace App\Admin\Http\Controllers\Area;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Http\Resources\Area\AreaSearchSelectResource;

class AreaSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        AreaRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse()
    {
        $this->instance = [
            'results' => AreaSearchSelectResource::collection($this->instance)
        ];
    }
}
<?php

namespace App\Admin\Repositories\Route;
use App\Admin\Repositories\EloquentRepository;
use App\Models\Route;

class RouteRepository extends EloquentRepository implements RouteRepositoryInterface
{


    public function getModel(): string
    {
        return Route::class;
    }

}

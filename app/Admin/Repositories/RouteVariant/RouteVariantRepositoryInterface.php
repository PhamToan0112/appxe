<?php

namespace App\Admin\Repositories\RouteVariant;


use App\Admin\Repositories\EloquentRepositoryInterface;

interface RouteVariantRepositoryInterface extends EloquentRepositoryInterface
{
    public function createRouteVariants($startTime, $endTime, $route,$driver): void;

}

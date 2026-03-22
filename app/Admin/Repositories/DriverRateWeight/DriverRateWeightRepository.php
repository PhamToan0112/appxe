<?php

namespace App\Admin\Repositories\DriverRateWeight;
use App\Admin\Repositories\EloquentRepository;
use App\Models\DriverRateWeight;

class DriverRateWeightRepository extends EloquentRepository implements DriverRateWeightRepositoryInterface
{


    public function getModel(): string
    {
        return DriverRateWeight::class;
    }

}

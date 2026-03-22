<?php

namespace App\Admin\Repositories\WeightRange;
use App\Admin\Repositories\EloquentRepository;
use App\Models\WeightRange;

class WeightRangeRepository extends EloquentRepository implements WeightRangeRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return WeightRange::class;
    }

}

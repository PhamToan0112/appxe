<?php

namespace App\Admin\Repositories\Area;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface AreaRepositoryInterface extends EloquentRepositoryInterface
{

    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);

}

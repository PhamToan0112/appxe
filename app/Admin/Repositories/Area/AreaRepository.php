<?php

namespace App\Admin\Repositories\Area;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Area\AreaStatus;
use App\Models\Area;

class AreaRepository extends EloquentRepository implements AreaRepositoryInterface
{


    public function getModel(): string
    {
        return Area::class;
    }

    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc'])
    {
        $this->getByQueryBuilder($filter, $relations, $sort);

        return $this->instance->get();
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model->where('status', '=', AreaStatus::On)->where('name', 'like', '%' . $keySearch . '%');

        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }

}

<?php

namespace App\Admin\Repositories\CategorySystem;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Models\CategorySystem;

class CategorySystemRepository extends EloquentRepository implements CategorySystemRepositoryInterface
{
    protected $select = [];

    public function getModel()
    { // Lấy dữ liệu từ Model Category System
        return CategorySystem::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    { // Lấy các dữ liệu từ Database ra Order By cột id DESC
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

}

<?php

namespace App\Api\V1\Repositories\CategorySystem;

use App\Admin\Repositories\CategorySystem\CategorySystemRepository as AdminCategorySystemRepository;
use App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Models\CategorySystem;

class CategorySystemRepository extends AdminCategorySystemRepository implements CategorySystemRepositoryInterface
{
    public function getModel()
    {
        return CategorySystem::class;
    }

    public function findByID($id)
    {
        $this->instance = $this->model->where('id', $id)
            ->firstOrFail();

        if ($this->instance && $this->instance->exists()) {
            return $this->instance;
        }

        return null;
    }
    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
            ->offset($page * $limit)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
        return $this->instance;
    }

}
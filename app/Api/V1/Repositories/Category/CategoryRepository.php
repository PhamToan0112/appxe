<?php

namespace App\Api\V1\Repositories\Category;

use App\Admin\Repositories\Category\CategoryRepository as AdminCategoryRepository;
use App\Api\V1\Repositories\Category\CategoryRepositoryInterface;
use App\Enums\ActiveStatus;

class CategoryRepository extends AdminCategoryRepository implements CategoryRepositoryInterface
{
    public function getTree()
    {
        $this->instance = $this->model->active()->orderBy('position', 'ASC')->get()->toTree();
        return $this->instance;
    }

    public function getCategoryActive(){
        $this->instance = $this->model->where('status', ActiveStatus::Active)->get();
        return $this->instance;
    }

    public function findByIdOrSlug($idOrSlug)
    {
        $this->instance = $this->model->whereIdOrSlug($idOrSlug)->firstOrFail();
        return $this->instance;
    }
    public function findByIdOrSlugWithAncestorsAndDescendants($idOrSlug)
    {
        $this->findByIdOrSlug($idOrSlug);

        $this->instance = $this->instance->load([
            'ancestors' => function ($query) {
                $query->defaultOrder();
            },
            'descendants'
        ]);
        return $this->instance;

    }

    public function getRootWithAllChildren()
    {
        $this->instance = $this->model->active()
            ->whereNull('parent_id')
            ->with(['descendants'])
            ->OrderBy('position', 'ASC')
            ->get();
        return $this->instance;
    }

}
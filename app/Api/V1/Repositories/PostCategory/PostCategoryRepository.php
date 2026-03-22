<?php

namespace App\Api\V1\Repositories\PostCategory;

use App\Admin\Repositories\PostCategory\PostCategoryRepository as AdminPostCategoryRepository;
use App\Api\V1\Repositories\PostCategory\PostCategoryRepositoryInterface;

class PostCategoryRepository extends AdminPostCategoryRepository implements PostCategoryRepositoryInterface
{
    public function getTree()
    {
        $this->instance = $this->model->published()
            ->orderBy('position', 'ASC')
            ->get()
            ->toTree();

        return $this->instance;
    }

    public function findByIdWithAncestorsAndDescendants($id)
    {
        $this->findOrFail($id);

        $this->instance = $this->instance->load([
            'ancestors' => function ($query) {
                $query->defaultOrder();
            },
            'descendants'
        ]);
        return $this->instance;

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
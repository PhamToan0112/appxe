<?php

namespace App\Admin\Repositories\Category;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Category::class;
    }

}

<?php

namespace App\Api\V1\Repositories\CategorySystem;

use App\Admin\Repositories\EloquentRepositoryInterface;


interface CategorySystemRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByID($id);
    public function paginate($page = 1, $limit = 10);
}
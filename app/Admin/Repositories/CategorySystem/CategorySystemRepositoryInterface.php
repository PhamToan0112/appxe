<?php

namespace App\Admin\Repositories\CategorySystem;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface CategorySystemRepositoryInterface extends EloquentRepositoryInterface
{

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'); // Lấy các dữ liệu từ Database ra Order By cột id DESC
}

<?php

namespace App\Api\V1\Repositories\ReportOrder;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ReportOrderRepositoryInterface extends EloquentRepositoryInterface
{
    public function create(array $data);
}

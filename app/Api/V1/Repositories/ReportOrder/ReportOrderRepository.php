<?php

namespace App\Api\V1\Repositories\ReportOrder;

use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderIssue;

class ReportOrderRepository extends EloquentRepository implements ReportOrderRepositoryInterface
{
    public function getModel(): string
    {
        return OrderIssue::class;
    }


    public function create(array $data)
    {
        return $this->model::create($data);
    }
}

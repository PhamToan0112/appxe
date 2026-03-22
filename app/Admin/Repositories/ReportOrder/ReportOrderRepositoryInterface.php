<?php

namespace App\Admin\Repositories\ReportOrder;


use App\Admin\Repositories\EloquentRepositoryInterface;

interface ReportOrderRepositoryInterface extends EloquentRepositoryInterface
{

    public function getOrderIssue($orderId);
}

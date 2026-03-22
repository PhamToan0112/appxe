<?php

namespace App\Admin\Repositories\ReportOrder;
use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderIssue;
use App\Models\Order;;

class ReportOrderRepository extends EloquentRepository implements ReportOrderRepositoryInterface
{


    public function getModel(): string
    {
        return Order::class;
    }

    public function getOrderIssue($orderId)
    {
        return OrderIssue::where('order_id',$orderId)->orderBy('id','desc')->get();
    }

}

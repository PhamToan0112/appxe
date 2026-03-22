<?php

namespace App\Api\V1\Repositories\Order;
use App\Admin\Repositories\Order\OrderRepository as AdminOrderRepository;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Models\OrderIssue;

class OrderRepository extends AdminOrderRepository implements OrderRepositoryInterface
{
    public function createOrderIssue(array $reports, int $orderId)
    {
        $issues = [];

        foreach ($reports as $report) {
            $issue = OrderIssue::create([
                'order_id' => $orderId,
                'description' => $report,
            ]);
            $issues[] = $issue; 
        }

        return $issues; 
    }

}

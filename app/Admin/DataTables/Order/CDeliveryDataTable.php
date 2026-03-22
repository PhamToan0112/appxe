<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;


class CDeliveryDataTable extends BaseDataTable
{


    protected $nameTable = 'cDeliveryTable';


    public function __construct(
        OrderRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.c-delivery.datatable.action',
            'status' => 'admin.c-delivery.datatable.status',
            'user' => 'admin.c-delivery.datatable.user',
            'driver' => 'admin.c-delivery.datatable.driver',
            'payment-method' => 'admin.c-delivery.datatable.payment',
            'code' => 'admin.c-delivery.datatable.code',
            'shipping_weight_range' => 'admin.c-delivery.datatable.shipping_weight_range',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $this->columnSearchDate = [];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderCDeliveryStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => PaymentMethod::asSelectArray()
            ],
            [
                'column' => 6,
                'data' => OrderType::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
            'order_type' => OrderType::C_Delivery
        ], ['user', 'vehicle', 'driver.user']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.c-delivery');
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => $this->view['code'],
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'total' => '{{ format_price($total) }}',
            'status' => $this->view['status'],
            'user' => $this->view['user'],
            'driver' => $this->view['driver'],
            'payment_method' => $this->view['payment-method'],
            'shippingWeightRange' => function ($order) {
                return view($this->view['shipping_weight_range'], [
                    'shippingWeightRange' => $order->shipments->first()->weightRange,
                ])->render();
            },
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'status', 'user', 'driver', 'payment_method', 'code', 'shippingWeightRange'];
    }
}

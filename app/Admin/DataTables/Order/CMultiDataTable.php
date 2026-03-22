<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\OpenStatus;
use App\Enums\Order\OrderCMultiStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;


class CMultiDataTable extends BaseDataTable
{


    protected $nameTable = 'cMultiTable';


    public function __construct(
        OrderRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.c-multi.datatable.action',
            'status' => 'admin.c-multi.datatable.status',
            'user' => 'admin.c-multi.datatable.user',
            'driver' => 'admin.c-multi.datatable.driver',
            'payment-method' => 'admin.c-multi.datatable.payment',
            'code' => 'admin.c-multi.datatable.code',
            'shipping_weight_range' => 'admin.c-multi.datatable.shipping_weight_range',
            'collection_from_sender_status' => 'admin.c-multi.datatable.collection_from_sender_status',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 7];

        $this->columnSearchDate = [7];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderCMultiStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => PaymentMethod::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
            'order_type' => OrderType::C_Multi
        ], ['user', 'vehicle', 'driver.user']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.c-multi');
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
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'action',
            'status',
            'user',
            'driver',
            'payment_method',
            'code',
        ];

    }
}

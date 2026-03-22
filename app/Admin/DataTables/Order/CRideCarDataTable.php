<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderCRideCarStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;


class CRideCarDataTable extends BaseDataTable
{


    protected $nameTable = 'cRideCarTable';


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
            'action' => 'admin.c-ride-car.datatable.action',
            'status' => 'admin.c-ride-car.datatable.status',
            'user' => 'admin.c-ride-car.datatable.user',
            'driver' => 'admin.c-ride-car.datatable.driver',
            'payment-method' => 'admin.c-ride-car.datatable.payment',
            'code' => 'admin.c-ride-car.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8,];

        $this->columnSearchDate = [];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderCRideCarStatus::asSelectArray()
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
            ['order_type', 'IN', [OrderType::C_CAR, OrderType::C_RIDE]]
        ], ['user', 'vehicle', 'driver.user']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.c-ride-car', []);
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
            'payment_method' => $this->view['payment-method']
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
        $this->customRawColumns = ['action', 'status', 'user', 'driver', 'payment_method', 'code'];
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
}

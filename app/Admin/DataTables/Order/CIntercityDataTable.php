<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderCIntercityStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;


class CIntercityDataTable extends BaseDataTable
{


    protected $nameTable = 'cIntercityTable';


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
            'action' => 'admin.c-intercity.datatable.action',
            'status' => 'admin.c-intercity.datatable.status',
            'trip_type' => 'admin.c-intercity.datatable.trip_type',
            'user' => 'admin.c-intercity.datatable.user',
            'driver' => 'admin.c-intercity.datatable.driver',
            'payment-method' => 'admin.c-intercity.datatable.payment',
            'code' => 'admin.c-intercity.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        $this->columnSearchDate = [7, 8, 9, 10, 12];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderCIntercityStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => PaymentMethod::asSelectArray()
            ],
            [
                'column' => 6,
                'data' => OrderType::asSelectArray()
            ],
            [
                'column' => 11,
                'data' => TripType::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
            'order_type' => OrderType::C_Intercity
        ], ['user', 'vehicle', 'driver.user']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.c-intercity');
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => $this->view['code'],
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'return_time' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'departure_time' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'total' => '{{ format_price($total) }}',
            'status' => $this->view['status'],
            'trip_type' => $this->view['trip_type'],
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

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'action',
            'status',
            'user',
            'driver',
            'payment_method',
            'code',
            'trip_type'
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
}

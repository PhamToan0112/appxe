<?php

namespace App\Admin\DataTables\Driver;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\DataTables\Driver\Traits\BaseDriver;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;

class OrderByDriverDatatable extends BaseDataTable
{
    use BaseDriver;

    protected $nameTable = 'OrderByDriverTable';

    public function __construct(
        DriverRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'order_type' => 'admin.drivers.orders.datatable.order_type',
            'code' => 'admin.drivers.orders.datatable.code',
            'user' => 'admin.drivers.orders.datatable.user',
            'trip_type' => 'admin.drivers.orders.datatable.trip_type',
            'status' => 'admin.drivers.orders.datatable.status',
            'action' => 'admin.drivers.orders.datatable.action',
            'note' => 'admin.drivers.orders.datatable.note',
            'create_at' => 'admin.drivers.orders.datatable.create_at',
            'payment_method' => 'admin.drivers.orders.datatable.payment_method',
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.order_by_driver', []);
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2 , 3, 4, 5, 6,7];

        $this->columnSearchDate = [7];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => OrderType::asSelectArray()
            ],
            [
                'column' => 2,
                'data' => PaymentMethod::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => OrderStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => TripType::asSelectArray()
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $driverId = request()->route('id');
        return $this->repository->getOrderByDriver($driverId);
    }
    

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => function($order){
                $orderType = $order->order_type ;
                $orderId = $order->id ;
                $code = $order->code ;
                return view($this->view['code'], compact(['orderType','orderId','code']));
            },
            'user' => function($order){
                $fullname = $order->user->fullname ;
                $userId = $order->user->id ;
                return view($this->view['user'], compact(['fullname','userId']));
            },
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'status' => $this->view['status'],
            'order_type' => $this->view['order_type'],
            'trip_type' => $this->view['trip_type'],
            'total' => '{{ format_price($total) }}',
            'payment_method' => $this->view['payment_method']
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['order_type', 'status', 'code','trip_type','user','total','payment_method'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'code' =>  function ($query,$keyword){
                $query->where('code', 'like', '%' . $keyword . '%');
            },
            'user' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }


}

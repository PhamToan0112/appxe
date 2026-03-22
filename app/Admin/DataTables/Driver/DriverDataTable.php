<?php

namespace App\Admin\DataTables\Driver;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\User\UserStatus;
use Illuminate\Database\Eloquent\Builder;

class DriverDataTable extends BaseDataTable
{

    protected $nameTable = 'DriverTable';

    public function __construct(
        DriverRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.drivers.datatable.action',
            'fullname' => 'admin.drivers.datatable.fullname',
            'role' => 'admin.drivers.datatable.role',
            'status' => 'admin.drivers.datatable.status',
            'order-status' => 'admin.drivers.datatable.order-status',
            'auto_accept' => 'admin.drivers.datatable.auto_accept',
            'discount' => 'admin.drivers.datatable.discount',
            'orders' => 'admin.drivers.datatable.orders',
            'orderCRideCar' => 'admin.drivers.datatable.orderCRideCar',
            'checkbox' => 'admin.common.checkbox',
            'review' => 'admin.drivers.datatable.review',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8, 9, 14];

        $this->columnSearchDate = [14];

        $this->columnSearchSelect = [
            [
                'column' => 7,
                'data' => DriverOrderStatus::asSelectArray()
            ],
            [
                'column' => 8,
                'data' => AutoAccept::asSelectArray()
            ],
            [
                'column' => 9,
                'data' => UserStatus::asSelectArray()
            ],
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.driver', []);
    }


    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder(
            ['is_verified' => VerificationStatus::Verified]
        )->driver();
    }


    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['review', 'fullname', 'action', 'auto_accept', 'order_status', 'status', 'discount', 'orderCRideCar', 'orders', 'checkbox'];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],

            'phone' => function ($driver) {
                return $driver->user->phone;
            },
            'email' => function ($driver) {
                return $driver->user->email;
            },
            'name' => function ($driver) {
                return $driver->user->bank->name ?? 'N/A';
            },
            'balance' => function ($driver) {
                return format_price($driver->user->wallet->balance ?? 'N/A');
            },
            'status' => function ($driver) {
                return view($this->view['status'], [
                    'status' => $driver->user->status->value,
                ])->render();
            },
            'checkbox' => $this->view['checkbox'],
            'review' => $this->view['review'],
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'fullname' => function ($driver) {
                return view($this->view['fullname'], [
                    'id' => $driver->id,
                    'fullname' => $driver->user->fullname,
                ])->render();
            },
            'order_status' => function ($driver) {
                return view($this->view['order-status'], [
                    'status' => $driver->order_status,
                ])->render();
            },
            'auto_accept' => function ($driver) {
                return view($this->view['auto_accept'], [
                    'status' => $driver->auto_accept->value,
                ])->render();
            },
            'discount' => function ($driver) {
                return view($this->view['discount'], [
                    'id' => $driver->id,
                ])->render();
            },
            'orderCRideCar' => function ($driver) {
                return view($this->view['orderCRideCar'], [
                    'id' => $driver->id,
                ])->render();
            },
            'orders' => function ($driver) {
                return view($this->view['orders'], [
                    'id' => $driver->id,
                ])->render();
            },
            'created_at' => '{{ format_date($created_at) }}',
            'booking_price' => '{{ format_price($booking_price) }}'
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'fullname' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'phone' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('phone', 'like', '%' . $keyword . '%');
                });
            },
            'status' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('status', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }


}
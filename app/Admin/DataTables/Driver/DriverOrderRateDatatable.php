<?php

namespace App\Admin\DataTables\Driver;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepository;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\Order\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DriverOrderRateDatatable extends BaseDataTable
{

    protected $nameTable = 'driverRateTable';

    public function __construct(
        DriverRepositoryInterface $repository,
        OrderRepository $orderRepository
    ) {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'cancel_rate' => 'admin.drivers.orderRate.datatable.cancel_rate',
            'name' => 'admin.drivers.orderRate.datatable.name',
            'total_order' => 'admin.drivers.orderRate.datatable.total_order',
            'cancel' => 'admin.drivers.orderRate.datatable.cancel',
            'complete' => 'admin.drivers.orderRate.datatable.complete',
            'complete_rate' => 'admin.drivers.orderRate.datatable.complete_rate',
            'return' => 'admin.drivers.orderRate.datatable.return',
            'return_rate' => 'admin.drivers.orderRate.datatable.return_rate',
            'status' => 'admin.drivers.datatable.status',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4];

        $this->columnSearchDate = [];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => DriverStatus::asSelectArray()
            ],
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.driver_cancel_rate', []);

    }


    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder(
            [
                'is_verified' => VerificationStatus::Verified,
            ],
            [],
        )->driver();
    }


    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'cancel_rate',
            'name',
            'order_cancel',
            'total_order',
            'cancel',
            'complete',
            'complete_rate',
            'return',
            'return_rate',
            'checkbox',
            'status'
        ];

    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'checkbox' => $this->view['checkbox']
        ];
    }

    protected function setCustomEditColumns(): void
    {

        $this->customEditColumns = [
            'phone' => function ($driver) {
                return $driver->user->phone;
            },
            'email' => function ($driver) {
                return $driver->user->email;
            },
            'name' => function ($driver) {
                return view($this->view['name'], ['name' => $driver->user->fullname ?? 'N/A', 'id' => $driver->id]);
            },

            'total_order' => function ($driver) {
                return view($this->view['total_order'], ['total_order' => $driver->orders->count(), 'id' => $driver->id]);
            },

            'cancel' => function ($driver) {
                return view($this->view['cancel'], ['cancel' => $driver->orders->where('status', OrderStatus::DriverCanceled)->count(), 'id' => $driver->id]);
            },

            'cancel_rate' => function ($driver) {
                $total = $driver->orders->count();
                $total_cancel = $driver->orders->where('status', OrderStatus::DriverCanceled)->count();

                $rate = $total > 0 ? round(($total_cancel / $total) * 100, 2) : 0;
                return $rate . '%';
            },
            'complete' => function ($driver) {
                return view($this->view['complete'], ['complete' => $driver->orders->where('status', OrderStatus::Completed)->count(), 'id' => $driver->id]);
            },
            'complete_rate' => function ($driver) {
                $total = $driver->orders->count();
                $total_complete = $driver->orders->where('status', OrderStatus::Completed)->count();

                $rate = $total > 0 ? round(($total_complete / $total) * 100, 2) : 0;
                return $rate . '%';
            },
            'return' => function ($driver) {
                return view($this->view['return'], ['return' => $driver->orders->where('status', OrderStatus::Returned)->count(), 'id' => $driver->id]);
            },
            'return_rate' => function ($driver) {
                $total = $driver->orders->count();
                $total_return = $driver->orders->where('status', OrderStatus::Returned)->count();

                $rate = $total > 0 ? round(($total_return / $total) * 100, 2) : 0;
                return $rate . '%';
            },
            'status' => function ($driver) {
                return view($this->view['status'], [
                    'status' => $driver->user->status->value,
                ])->render();
            },
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'name' => function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('fullname', 'LIKE', "%$search%");
                });
            },

            'phone' => function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('phone', 'LIKE', "%$search%");
                });
            },

            'email' => function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('email', 'LIKE', "%$search%");
                });
            },

            'status' => function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('status', $search);
                });
            },
        ];
    }

}
<?php

namespace App\Admin\DataTables\Driver;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\DataTables\Driver\Traits\BaseDriver;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\User\UserStatus;
use Illuminate\Database\Eloquent\Builder;

class PendingDriverDataTable extends BaseDataTable
{
    use BaseDriver;

    protected $nameTable = 'DriverPendingTable';

    public function __construct(
        DriverRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.drivers.datatable.action-pending-driver',
            'fullname' => 'admin.drivers.datatable.fullname',
            'role' => 'admin.drivers.datatable.role',
            'status' => 'admin.drivers.datatable.status',
            'order-status' => 'admin.drivers.datatable.order-status',
            'auto_accept' => 'admin.drivers.datatable.auto_accept',
            'is-verified' => 'admin.drivers.datatable.is-verified',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.pending_driver', []);
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8];

        $this->columnSearchDate = [8];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => DriverOrderStatus::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => AutoAccept::asSelectArray()
            ],
            [
                'column' => 6,
                'data' => UserStatus::asSelectArray()
            ],
            [
                'column' => 7,
                'data' => VerificationStatus::asSelectArray()
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
        return $this->repository->getByQueryBuilder(
            [
                'is_verified' => VerificationStatus::Unverified
            ]
        );
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
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'is_verified' => $this->view['is-verified'],
            'phone' => function ($driver) {
                return $driver->user->phone;
            },
            'status' => function ($driver) {
                return view($this->view['status'], [
                    'status' => $driver->user->status->value,
                ])->render();
            },
            'checkbox' => $this->view['checkbox'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['fullname', 'action', 'auto_accept', 'order_status', 'status', 'is_verified', 'checkbox'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'fullname' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
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
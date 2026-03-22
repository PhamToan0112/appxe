<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Enums\OpenStatus;
use App\Enums\User\Gender;
use App\Enums\User\UserStatus;
use App\Enums\User\UserActive;
use Illuminate\Database\Eloquent\Builder;

class UserDataTable extends BaseDataTable
{
    use Roles;

    protected $nameTable = 'userTable';

    public function __construct(
        UserRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.users.datatable.action',
            'fullname' => 'admin.users.datatable.fullname',
            'status' => 'admin.users.datatable.status',
            'active' => 'admin.users.datatable.active',
            'role' => 'admin.users.datatable.role',
            'order_history' => 'admin.users.datatable.order_history',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => Gender::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => UserStatus::asSelectArray()
            ],
            [
                'column' => 7,
                'data' => OpenStatus::asSelectArray()
            ],
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy()
            ->whereHas('roles', function ($query) {
                $query->where('name', $this->getRoleCustomer());
            })
            ->with(['bank', 'wallet']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.user', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'fullname' => $this->view['fullname'],
            'gender' => function ($user) {
                return $user->gender->description();
            },
            'status' => function ($user) {
                return view($this->view['status'], [
                    'status' => $user->status->value,
                ])->render();
            },
            'active' => $this->view['active'],
            'name' => function ($user) {
                return $user->bank->name ?? 'N/A';
            },
            'balance' => function ($user) {
                return format_price($user->wallet->balance ?? 'N/A');
            },
            'order_history' => $this->view['order_history'],

            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'checkbox' => $this->view['checkbox'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['fullname', 'area_id', 'action',
            'status', 'active', 'order_history', 'checkbox'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'name' => function ($query, $keyword) {
                $query->whereHas('bank', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}

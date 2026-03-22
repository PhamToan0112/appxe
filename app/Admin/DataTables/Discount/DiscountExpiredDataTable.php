<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DiscountExpiredDataTable extends BaseDataTable
{

    protected $nameTable = 'discountTable';

    public function __construct(
        DiscountRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.discounts.datatable.action',
            'title' => 'admin.discounts.datatable.title',
            'edit_link' => 'admin.discounts.datatable.edit-link',
            'stores' => 'admin.discounts.datatable.stores',
            'users' => 'admin.discounts.datatable.users',
            'drivers' => 'admin.discounts.datatable.drivers',
            'type' => 'admin.discounts.datatable.type',
            'status' => 'admin.discounts.datatable.status',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $this->columnSearchDate = [4, 5];

        $this->columnSearchSelect = [
            [
                'column' => 8,
                'data' => DiscountType::asSelectArray()
            ],
            [
                'column' => 10,
                'data' => DiscountStatus::asSelectArray()
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
        return $this->repository->getByQueryBuilder([], ['users', 'drivers'])->expired();

    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.discount', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [

            'code' => $this->view['edit_link'],
            'date_end' => '{{ format_datetime($date_end) }}',
            'date_start' => '{{ format_datetime($date_start) }}',
            'min_order_amount' => '{{ format_price($min_order_amount) }}',
            'discount_value' => '{{ format_price($discount_value) }}',
            'status' => $this->view['status'],
            'type' => $this->view['type'],

            'drivers' => function ($discount) {
                $drivers = $discount->drivers;
                return view($this->view['drivers'], [
                    'drivers' => $drivers,
                    'driver_option' => $discount->driver_option,
                    'discount' => $discount
                ])->render();
            },
            'users' => function ($discount) {
                $users = $discount->users;
                return view($this->view['users'], [
                    'users' => $users,
                    'user_option' => $discount->user_option,
                    'discount' => $discount
                ])->render();
            }

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
        $this->customRawColumns = ['action', 'code', 'stores', 'users', 'drivers', 'type', 'status', 'checkbox'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'users' => function ($query, $keyword) {
                $query->whereHas('users', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'drivers' => function ($query, $keyword) {
                $query->whereHas('drivers.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}

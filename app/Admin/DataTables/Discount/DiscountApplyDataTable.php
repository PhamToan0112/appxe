<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use Illuminate\Database\Eloquent\Builder;

class DiscountApplyDataTable extends BaseDataTable
{

    protected $nameTable = 'discountTable';

    public function __construct(
        DiscountRepositoryInterface $repository,
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'user' => 'admin.discounts.apply.datatable.user',
            'driver' => 'admin.discounts.apply.datatable.driver',
            'status' => 'admin.discounts.apply.datatable.status',
            'type' => 'admin.discounts.apply.datatable.type',
            'value' => 'admin.discounts.apply.datatable.value',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];

        $this->columnSearchDate = [3, 2];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => DiscountType::asSelectArray(),
            ],
            [
                'column' => 6,
                'data' => DiscountStatus::asSelectArray(),
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
        $discountId = request()->route('discountId');
        return $this->repository->getApplyDiscount($discountId);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.discount_apply', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'user' => function ($row) {
                return view($this->view['user'], ['row' => $row->user_id])->render();
            },
            'driver' => function ($row) {
                return view($this->view['driver'], ['row' => $row->driver_id])->render();
            },
            'date_start' => function ($row) {
                return format_datetime($row->date_start);
            },
            'date_end' => function ($row) {
                return format_datetime($row->date_end);
            },
            'status' => $this->view['status'],
            'value' => function ($row) {
                if ($row->type == DiscountType::Money) {
                    return format_price($row->discount_value);
                } elseif ($row->type == DiscountType::Percent) {
                    return $row->percent_value . '%';
                }
            },
            'type' => $this->view['type'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'value' => $this->view['value'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['user', 'driver', 'status', 'value', 'type'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user' => function ($query, $keyword) {
                $query->whereHas('users', function ($subQuery) use ($keyword) {
                    $subQuery->where('users.fullname', 'like', '%' . $keyword . '%');
                });
            },

            'driver' => function ($query, $keyword) {
                $query->whereHas('drivers.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },

            'value' => function ($query, $keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('discounts.discount_value', 'like', '%' . $keyword . '%')
                        ->orWhere('discounts.percent_value', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}

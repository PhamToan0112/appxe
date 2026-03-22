<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use Illuminate\Database\Eloquent\Builder;

class DriverDiscountDataTable extends BaseDataTable
{

    protected $nameTable = 'dicountAppticationTable';

    public function __construct(
        DiscountRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.drivers.discount.datatable.action',
            'title' => 'admin.drivers.discount.datatable.title',
            'edit_link' => 'admin.drivers.discount.datatable.edit-link',
            'stores' => 'admin.drivers.discount.datatable.stores',
            'type' => 'admin.drivers.discount.datatable.type',
            'status' => 'admin.drivers.discount.datatable.status',
            'code' => 'admin.drivers.discount.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7];

        $this->columnSearchDate = [1, 2];

        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => DiscountType::asSelectArray()
            ],
            [
                'column' => 7,
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
        return $this->repository->getDriverDiscount(request()->route('id'));
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.driver_discount', []);
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
        $this->customRawColumns = ['action', 'code', 'stores', 'type', 'status'];
    }

}
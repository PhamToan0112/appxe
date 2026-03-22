<?php

namespace App\Admin\DataTables\Topping;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Enums\Topping\ToppingStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class ToppingDataTable extends BaseDataTable
{

    protected $nameTable = 'toppingTable';

    public function __construct(
        ToppingRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.toppings.datatable.action',
            'edit_link' => 'admin.toppings.datatable.edit-link',
            'avatar' => 'admin.toppings.datatable.avatar',
            'price' => 'admin.toppings.datatable.price',
            'status' => 'admin.toppings.datatable.status',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => ToppingStatus::asSelectArray()
            ],
        ];

    }

    /**
     * Get query source of dataTable.
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilder();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.topping', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'avatar' => $this->view['avatar'],
            'status' => $this->view['status'],
            'created_at' => '{{ format_date($created_at) }}',
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
        $this->customRawColumns = ['action', 'name', 'avatar', 'price', 'status'];
    }
}

<?php

namespace App\Admin\DataTables\WeightRange;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Enums\DefaultStatus;


class WeightRangeDataTable extends BaseDataTable
{


    protected $nameTable = 'WeightRangeDataTable';


    public function __construct(
        WeightRangeRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.weight_ranges.datatable.action',
            'name' => 'admin.weight_ranges.datatable.name',
            'status' => 'admin.weight_ranges.datatable.status',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3,4];

        $this->columnSearchDate = [3];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => DefaultStatus::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilder();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.weight_range', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'id' => $this->view['name'],
            'created_at' => '{{ $created_at ? format_date($created_at) : "" }}',
            'status' => $this->view['status'],
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
        $this->customRawColumns = ['id', 'action', 'status'];
    }
}

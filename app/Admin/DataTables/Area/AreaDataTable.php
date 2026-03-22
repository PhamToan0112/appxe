<?php

namespace App\Admin\DataTables\Area;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Enums\Area\AreaStatus;


class AreaDataTable extends BaseDataTable
{


    protected $nameTable = 'areaTable';


    public function __construct(
        AreaRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.areas.datatable.action',
            'name' => 'admin.areas.datatable.name',
            'status' => 'admin.areas.datatable.status',
            'fee' => 'admin.areas.datatable.fee',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3 , 4];

        $this->columnSearchDate = [1];

        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => AreaStatus::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy('position', 'asc');
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.area', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'created_at' => '{{ $created_at ? format_date($created_at) : "" }}',
            'status' => $this->view['status'],
            'fee' => $this->view['fee']
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
        $this->customRawColumns = ['name', 'action', 'status' , 'fee'];
    }
}

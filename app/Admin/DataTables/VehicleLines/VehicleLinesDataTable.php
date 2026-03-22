<?php

namespace App\Admin\DataTables\VehicleLines;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Builder;


class VehicleLinesDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'vehicleLinesTable';


    protected array $actions = ['reset', 'reload'];

    public function __construct(
        VehicleLinesRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'name' => 'admin.vehicleLines.datatable.name',
            'description' => 'admin.vehicleLines.datatable.description',
            'status' => 'admin.vehicleLines.datatable.status',
            'action' => 'admin.vehicleLines.datatable.action',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    public function query(): Builder
    {
        return $this->repository->getQueryBuilder()->orderBy('id', 'desc');
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.vehicleLines', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'checkbox' => $this->view['checkbox'],
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [1, 2, 3];
        $this->columnSearchSelect = [
            [
                'column' =>3,
                'data' => DefaultStatus::asSelectArray()
            ],
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'description' => $this->view['description'],
            'status' => $this->view['status'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'name', 'status', 'description', 'checkbox'];
    }

    protected function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'name' => function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            },
        ];
    }
}
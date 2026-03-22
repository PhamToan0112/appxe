<?php

namespace App\Admin\DataTables\Vehicle;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Order\OrderType;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Builder;


class VehicleDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'vehicleTable';


    protected array $actions = ['reset', 'reload'];

    public function __construct(
        VehicleRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'type' => 'admin.vehicle.datatable.type',
            'action' => 'admin.vehicle.datatable.action',
            'editlink' => 'admin.vehicle.datatable.editlink',
            'desc' => 'admin.vehicle.datatable.desc',
            'driver' => 'admin.vehicle.datatable.driver',
            'status' => 'admin.vehicle.datatable.status',
            'checkbox' => 'admin.notifications.datatable.checkbox',
            'service_type' => 'admin.vehicle.datatable.service_type',
        ];
    }

    public function query(): Builder
    {   
        return $this->repository->getQueryBuilder();
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.vehicle', []);
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

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        $this->columnSearchSelect = [
            [
                'column' => 6,
                'data' => VehicleStatus::asSelectArray()
            ],
            [
                'column' => 8,
                'data' => VehicleType::asSelectArray()
            ],
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'type' => $this->view['type'],
            'code' => $this->view['editlink'],
            'desc' => $this->view['desc'],
            'status' => $this->view['status'],
            'driver' => function ($vehicle) {
                return view($this->view['driver'], [
                    'vehicle' => $vehicle,
                ])->render();
            },
            'service_type' => function ($vehicle) {
                return view($this->view['service_type'], [
                    'service_type' => json_decode($vehicle->service_type),
                ])->render();
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['code', 'type', 'action', 'desc', 'driver', 'status', 'checkbox', 'service_type'];
    }

    protected function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'service_type' => function ($query, $keyword){
                $query->where('service_type' , 'like', '%' . $keyword . '%');
            }
        ];
    }
}

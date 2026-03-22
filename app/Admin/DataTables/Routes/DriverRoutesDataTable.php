<?php

namespace App\Admin\DataTables\Routes;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Route\RouteRepositoryInterface;


class DriverRoutesDataTable extends BaseDataTable
{


    protected $nameTable = 'routesTable';


    public function __construct(
        RouteRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.routes.datatable.action',
            'id' => 'admin.routes.datatable.id',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        $this->columnSearchDate = [9];

    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
            'driver_id' => request()->route('driverId'),
        ], ['driver']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.driver-routes', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'id' => $this->view['id'],
            'price' => '{{ format_price($price) }}',
            'return_price' => '{{ format_price($return_price) }}',
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
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
        $this->customRawColumns = ['action', 'id'];
    }
}
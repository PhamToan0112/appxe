<?php

namespace App\Admin\DataTables\Routes;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Route\RouteRepositoryInterface;


class RoutesDataTable extends BaseDataTable
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
            'action' => 'admin.c-intercity.routes.datatable.action',
            'id' => 'admin.c-intercity.routes.datatable.id',
            'driver' => 'admin.c-intercity.routes.datatable.driver',
            'checkbox' => 'admin.common.checkbox',
            'route_variant' => 'admin.c-intercity.routes.datatable.route_variant',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4, 5, 6, 7];

        $this->columnSearchDate = [7];

    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
        ], ['driver']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.routes', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'checkbox' => $this->view['checkbox'],
            'id' => $this->view['id'],
            'price' => '{{ format_price($price) }}',
            'return_price' => '{{ format_price($return_price) }}',
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'driver' => function ($routes) {
                return view($this->view['driver'], [
                    'driver' => $routes->driver,
                ])->render();
            },
            'route_variant' => $this->view['route_variant'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver', function ($query) use ($keyword) {
                    $query->whereHas('user', function ($query) use ($keyword) {
                        $query->where('fullname', 'like', '%' . $keyword . '%');
                    });
                });
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'id', 'driver', 'checkbox', 'route_variant'];
    }
}

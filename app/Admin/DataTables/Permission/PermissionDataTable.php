<?php

namespace App\Admin\DataTables\Permission;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Permission\PermissionRepositoryInterface;


class PermissionDataTable extends BaseDataTable
{


    protected $nameTable = 'permissionTable';


    public function __construct(
        PermissionRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'id' => 'admin.permission.datatable.cotid',
            'title' => 'admin.permission.datatable.title',
            'action' => 'admin.permission.datatable.action',
            'guardname' => 'admin.permission.datatable.guardname',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4];

    }


    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.permission', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'title' => $this->view['title'],
            'guard_name' => $this->view['guardname'],
            'module_id' => function ($permission) {
                return $permission->getModuleName();
            },
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
        $this->customRawColumns = ['name', 'action', 'title', 'guard_name', 'module_id'];
    }


}

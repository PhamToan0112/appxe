<?php

namespace App\Admin\DataTables\CategorySystem;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\ActiveStatus;
use App\Models\CategorySystem;

class CategorySystemDataTable extends BaseDataTable
{

    use GetConfig;
    // ID ( Client ) của bảng DataTable
    protected $nameTable = 'category_systemTable';
    /**
     * Available button actions. When calling an action, the value will be used
     * as the function name (so it should be available)
     * If you want to add or disable an action, overload and modify this property.
     *
     * @var array
     */
    // protected array $actions = ['pageLength', 'excel', 'reset', 'reload'];

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        CategorySystemRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function getView()
    {
        return [
            'name' => 'admin.category_systems.datatable.name',
            'action' => 'admin.category_systems.datatable.action',
            'avatar' => 'admin.category_systems.datatable.avatar',
            'status' => 'admin.category_systems.datatable.status',
            // 'created_at' => 'admin.category_systems.datatable.created_at',
        ];
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CategorySystem $model
     * @return \Illuminate\Database\Eloquent\Builder
     * Hàm thực thi gọi lệnh truy xuất từ Database ( Repository )
     */

    public function query()
    {
        $query = $this->repository->getQueryBuilder();
        return $query;
    }

    /**
     * Get columns.
     *
     * @return array
     * Hàm kết nối tới datatable_columns Config
     */

    protected function setCustomColumns()
    {
        $this->customColumns = config('datatables_columns.category_system', []);
    }
    // Thiết lập Sửa một cột
    protected function setCustomEditColumns()
    {
        // Danh sách các mảng view cột sẽ sửa lại
        $this->customEditColumns = [
            'name' => $this->view['name'] ?? 'admin.category_systems.datatable.name',
            'created_at' => '{{ date("d-m-Y H:i:s", strtotime($created_at)) }}',
            'avatar' => $this->view['avatar'] ?? 'admin.category_systems.datatable.avatar',
            'status' => $this->view['status'] ?? 'admin.category_systems.datatable.status',
        ];
    }


    // Thiết lập Thêm một cột
    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'] ?? 'admin.category_systems.datatable.action',
        ];
    }


    // Thiết lập Cột Nguyên Thủy Không Bị Dính HTML
    // Truyền vào là 1 mảng tên các cột
    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['name', 'avatar', 'action', 'status'];
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 2, 3];
        $this->columnSearchDate = [3];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => ActiveStatus::asSelectArray()
            ],

        ];
    }
}
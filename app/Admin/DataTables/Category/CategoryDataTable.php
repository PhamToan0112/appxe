<?php 
namespace App\Admin\DataTables\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Enums\ActiveStatus;
use App\Admin\Traits\GetConfig;
use Illuminate\Database\Eloquent\Builder;

class CategoryDataTable extends BaseDataTable
{   
    protected $nameTable = 'categoryTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        CategoryRepositoryInterface $repository
    )
    {
      
        parent::__construct();
        $this->repository = $repository;
    }

    public function setView():void
    {
        $this->view = [
            'action' => 'admin.category.datatable.action',
            'name' => 'admin.category.datatable.name',
            'description' => 'admin.category.datatable.description',
            'status' => 'admin.category.datatable.status'
        ];
    }

    public function query(): Builder
    {
        return $this->repository->getQueryBuilder();
    }

    public function setColumnSearch():void
    {
        $this->columnAllSearch = [0,1,2];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => ActiveStatus::asSelectArray()
            ],

        ];
    }

    protected function setCustomColumns(): void
    {   
        $this->customColumns = config('datatables_columns.category', []);
    }

    protected function setCustomEditColumns():void
    {
        $this->customEditColumns = [
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'name' => $this->view['name'],
            'description' => $this-> view['description'], 
            'status' => $this->view['status']
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
        $this->customRawColumns = [ 'action', 'name', 'description' , 'status' ];
    }
}
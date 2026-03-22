<?php

namespace App\Admin\DataTables\Holiday;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Holiday\HolidayRepositoryInterface;
use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Builder;

class HolidayDataTable extends BaseDataTable
{

    protected $nameTable = 'holidayTable';

    public function __construct(
        HolidayRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.holidays.datatable.action',
            'name' => 'admin.holidays.datatable.name',
            'status' => 'admin.holidays.datatable.status',
            'checkbox' => 'admin.common.checkbox',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [ 1, 2 , 3];

        $this->columnSearchDate = [2];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => DefaultStatus::asSelectArray()
            ],
        ];

    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([]);

    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.holiday', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [

            'name' => $this->view['name'],
            'date' => '{{ format_date($date) }}',
            'status' =>  $this->view['status'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'checkbox' => $this->view['checkbox'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'name', 'status','checkbox'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'name' => function ($query, $keyword) {
                $query->where('name','like','%'. $keyword . '%');
            },
        ];
    }
}

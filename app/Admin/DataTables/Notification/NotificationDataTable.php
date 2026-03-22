<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\DataTables\Notification\trait\BaseNotification;
use App\Enums\Notification\NotificationStatus;

class NotificationDataTable extends BaseDataTable
{
    use BaseNotification;

    protected $nameTable = 'notificationTable';


    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [4, 5, 6];
        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => NotificationStatus::asSelectArray(),
            ],
        ];
    }


    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy()
            ->select('notifications.*')
            ->with(['driver.user', 'user']);
    }



    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.notifications');
    }



}

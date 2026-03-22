<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\DataTables\Notification\trait\BaseNotification;

use App\Enums\Notification\MessageType;
use App\Enums\Notification\NotificationStatus;
use App\Enums\VerifiedStatus;

class NotificationDepositDataTable extends BaseDataTable
{
    use BaseNotification;

    protected $nameTable = 'depositNotificationTable';


    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [3, 4, 5, 6,];
        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => NotificationStatus::asSelectArray(),
            ],
            [
                'column' => 5,
                'data' => VerifiedStatus::asSelectArray(),
            ],
        ];
    }


    public function query()
    {
        return $this->repository->getByQueryBuilder([
            'type' => MessageType::DEPOSIT,
            'admin_id' => null

        ], ['driver.user', 'user']);

    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.notifications_deposit');
    }


    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'checkbox' => $this->view['checkbox'],
        ];
    }


}

<?php

namespace App\Admin\DataTables\Notification\trait;


use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;

trait BaseNotification
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface         $userRepository,
    )
    {
        $this->repository = $repository;

        $this->userRepository = $userRepository;

        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.notifications.datatable.action',
            'title' => 'admin.notifications.datatable.title',
            'edit_link_driver' => 'admin.notifications.datatable.edit-link-driver',
            'edit_link_customer' => 'admin.notifications.datatable.edit-link-customer',
            'status' => 'admin.notifications.datatable.status',
            'is_verified' => 'admin.notifications.datatable.is_verified',
            'read_at' => 'admin.notifications.datatable.read_at',
            'checkbox' => 'admin.notifications.datatable.checkbox',
        ];
    }
    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'title' => $this->view['title'],
            'status' => $this->view['status'],
            'is_verified' => $this->view['is_verified'],
            'driver_id' => $this->view['edit_link_driver'],
            'user_id' => $this->view['edit_link_customer'],
            'created_at' => '{{ format_datetime($created_at) }}',
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
        $this->customRawColumns = ['action', 'status', 'checkbox', 'user_id', 'driver_id', 'title','is_verified'];
    }

}

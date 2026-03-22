<?php

namespace App\Api\V1\Repositories\Notification;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface NotificationRepositoryInterface extends EloquentRepositoryInterface
{
    public function detail($id);

    public function delete($id);

    public function getNotificationById($role, $userId, $page = 1, $limit = 10);

    public function markAsRead($id);
}

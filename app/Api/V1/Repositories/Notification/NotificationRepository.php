<?php

namespace App\Api\V1\Repositories\Notification;
use \App\Admin\Repositories\Notification\NotificationRepository as AdminArea;
use App\Models\Notification;
use App\Enums\Notification\NotificationStatus;

class NotificationRepository extends AdminArea implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(Notification $note)
    {
        $this->model = $note;
    }

    public function detail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getNotificationById($role, $userId, $page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        if ($userId) {
            return $this->model->where($role, $userId)
                ->offset($page * $limit)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
        };

        return false;
    }

    public function markAsRead($id){
      return $this->detail($id)->markAsRead();
    }
}

<?php

namespace App\Admin\Services\Notification;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;
use App\Enums\Notification\MessageType;
interface NotificationServiceInterface
{
    /**
     * Tạo mới
     *
     * @return mixed
     * @var Illuminate\Http\Request $request
     *
     */
    public function store(Request $request);

    /**
     * Cập nhật
     *
     * @return boolean
     * @var Illuminate\Http\Request $request
     *
     */
    public function update(Request $request);

    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete($id);

    public function updateDeviceToken($request);

    public function getNotifications(Request $request);

    public function updateStatus(Request $request);

    public function actionMultipleRecode(Request $request): bool;

    public function pendingDriverConfirmation($order);
    public function pendingUserConfirmation($order);
    public function driverConfirmedOrder($order);
    public function userConfirmedOrder($order);
    public function driverDeclinedOrder($order);
    public function userDeclinedOrder($order);
    public function inTransitOrder($order);
    public function completedOrder($order);
    public function cancelledOrder($order);
    public function driverCancelledOrder($order);
    public function userCancelledOrder($order);
    public function driverOnWayToPickUp($order);
    public function returnedOrder($order);
}

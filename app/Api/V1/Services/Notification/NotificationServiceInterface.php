<?php

namespace App\Api\V1\Services\Notification;

use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

interface NotificationServiceInterface
{


    public function delete($id): bool;

    /**
     * Send a notification to a specific driver.
     *
     * @param Driver $driver
     * @param Order $order
     * @return void True if the notification was sent successfully, false otherwise.
     */
    public function sendNotificationNewOrderToDriver(Driver $driver, Order $order): void;

    /**
     * Send a notification to a specific driver that they have confirmed the order.
     *
     * @param User $user
     * @param Order $order
     * @return void
     */
    public function sendDriverConfirmedNotification(User $user, Order $order): void;

    /**
     * Send a notification to a customer that the driver has declined the order.
     *
     * @param User $user
     * @param Order $order
     * @return void
     */
    public function sendCustomerDriverDeclinedNotification(User $user, Order $order): void;

    /**
     * Send a notification to a customer that a driver has selected them.
     *
     * @param User $customer
     * @param Order $order
     * @return void
     */
    public function sendDriverSelectedCustomerNotification(User $customer, Order $order): void;

    /**
     * Send a notification to a driver that a customer has declined them.
     *
     * @param Driver $driver
     * @param Order $order
     * @return void
     */
    public function sendCustomerDeclinedDriverNotification(Driver $driver, Order $order): void;


    /**
     * Send a successful deposit notification to a user.
     *
     * @param User $user Người dùng nhận thông báo.
     * @param float $amount Số tiền đã nạp.
     * @return void
     */
    public function sendSuccessfulDepositNotification(User $user, float $amount): void;

    /**
     * Send a successful withdrawal notification to a user.
     *
     * @param User $user Người dùng nhận thông báo.
     * @param float $amount Số tiền đã rút.
     * @return void
     */
    public function sendSuccessfulWithdrawalNotification(User $user, float $amount): void;

    /**
     * Send a successful payment notification to a user.
     *
     * @param User $user Người dùng nhận thông báo.
     * @param float $amount Số tiền đã thanh toán.
     * @return void
     */
    public function sendSuccessfulPaymentNotification(User $user, float $amount): void;

    /**
     * Send a notification to a user when an order is successfully completed.
     *
     * @param User $user
     * @param float $amount
     * @return void
     */
    public function sendOrderCompletedNotification(float $amount, $order): void;

    /**
     * Send a notification to a customer that the driver is on their way to pick up the order.
     *
     * @param User $user
     * @param Order $order Order for which the notification is being sent.
     * @return void
     */
    public function sendDriverOnWayToPickUpNotification(User $user, Order $order): void;

    /**
     * Send a notification to a user about the temporary holding of funds for an order.
     *
     * @param User $user The user to whom the notification will be sent.
     * @param Order $order The order associated with the funds being held.
     * @return void
     */
    public function sendOrderHoldNotification(User $user, Order $order): void;

    public function sendCustomerCanceledNotification(User $user, Order $order): void;

    public function sendDriverCanceledNotification(User $user, Order $order): void;

    public function sendNotificationsToAdmins(string $title, string $body, $type, bool $sendEmail = true);

    public function sendDriverOnTheMoveNotification(User $user, Order $order): void;

    public function sendDriverWantsToTakeOrderNotification(User $user, Order $order): void;

    public function sendCustomerAcceptedOrderNotification(User $user, Order $order): void;


    public function getNotifications(Request $request);

    public function detail($id);

    public function markAsRead($id);

    public function completedOrder(User $user, Order $order);
}

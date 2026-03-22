<?php

namespace App\Api\V1\Services\Notification;

use App\Admin\Traits\Roles;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Notification\MessageType;
use App\Enums\Order\OrderType;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Models\Admin;
use App\Traits\NotifiesViaFirebase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationService implements NotificationServiceInterface
{
    use NotifiesViaFirebase, Roles;

    use AuthServiceApi;

    protected NotificationRepositoryInterface $repository;

    protected DriverRepositoryInterface $driverRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface         $userRepository,
        DriverRepositoryInterface       $driverRepository
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->driverRepository = $driverRepository;

    }

    /**
     * @throws Exception
     */
    public function sendNotificationNewOrderToDriver(Driver $driver, Order $order): void
    {
        $title = config('notifications.new_order.title');
        $bodyTemplate = config('notifications.new_order.message');
        $body = str_replace('{order_code}', $order->code, $bodyTemplate);
        $this->sendFirebaseNotificationToDriver($driver, $title, $body);
    }


    /**
     * @throws Exception
     */
    public function sendDriverConfirmedNotification(User $user, Order $order): void
    {

        if ($order->order_type == OrderType::C_Delivery) {
            $title = config('notifications.driver_reconfirm_order.title');
            $bodyTemplate = config('notifications.driver_reconfirm_order.message');
        } else {
            $title = config('notifications.driver_confirmed_order.title');
            $bodyTemplate = config('notifications.driver_confirmed_order.message');
        }

        $body = str_replace('{order_code}', $order->code, $bodyTemplate);

        $this->sendFirebaseNotificationToUser($user, $title, $body);
    }


    /**
     * @throws Exception
     */
    public function delete($id): bool
    {
        return $this->repository->delete($id);

    }

    public function sendCustomerDriverDeclinedNotification(User $user, Order $order): void
    {
        $title = config('notifications.driver_declined_order.title');
        $bodyTemplate = config('notifications.driver_declined_order.message');
        $body = str_replace('{driver_name}', $user->fullname, $bodyTemplate);
        $this->sendFirebaseNotificationToUser($user, $title, $body);
    }

    public function sendDriverSelectedCustomerNotification(User $customer, Order $order): void
    {
        $title = config('notifications.driver_selected_customer.title');
        $bodyTemplate = config('notifications.driver_selected_customer.message');
        $body = str_replace('{driver_name}', $order->driver->user->fullname, $bodyTemplate);
        $this->sendFirebaseNotificationToUser($customer, $title, $body);
    }

    public function sendDriverOnWayToPickUpNotification(User $user, Order $order): void
    {
        $title = config('notifications.driver_on_way_to_pick_up.title');
        $bodyTemplate = config('notifications.driver_on_way_to_pick_up.message');
        $body = str_replace('{order_code}', $order->code, $bodyTemplate);

        $this->sendFirebaseNotificationToUser($user, $title, $body);
    }

    public function sendCustomerCanceledNotification(User $user, Order $order): void
    {
        $title = config('notifications.driver_canceled_order.title');
        $bodyTemplate = config('notifications.driver_canceled_order.message');

        $body = str_replace('{order_code}', $order->code, $bodyTemplate);
        $this->sendFirebaseNotificationToUser($user, $title, $body);
    }

    public function sendDriverCanceledNotification(User $user, Order $order): void
    {
        $title = config('notifications.customer_canceled_order.title');
        $bodyTemplate = config('notifications.customer_canceled_order.message');

        $body = str_replace('{order_code}', $order->code, $bodyTemplate);
        $this->sendFirebaseNotificationToUser($user, $title, $body);
    }


    /**3
     * @throws Exception
     */
    public function sendCustomerDeclinedDriverNotification(Driver $driver, Order $order): void
    {
        $title = config('notifications.customer_declined_driver.title');
        $bodyTemplate = config('notifications.customer_declined_driver.message');
        $body = str_replace('{customer_name}', $order->user->fullname, $bodyTemplate);

        $this->sendFirebaseNotificationToDriver($driver, $title, $body);
    }

    public function sendDriverOnTheMoveNotification(User $user, Order $order): void
    {
        $title = config('notifications.driver_on_the_move.title');
        $bodyTemplate = config('notifications.driver_on_the_move.message');
        $body = str_replace('{order_code}', $order->code, $bodyTemplate);

        // Send the notification using Firebase
        $this->sendFirebaseNotificationToUser($order->user, $title, $body);
    }

    public function sendCustomerAcceptedOrderNotification(User $user, Order $order): void
    {
        $title = config('notifications.customer_accepted_order.title');
        $bodyTemplate = config('notifications.customer_accepted_order.message');
        $message = str_replace(
            ['{customer_name}', '{order_code}'],
            [$user->fullname, $order->code],
            $bodyTemplate
        );

        $this->sendFirebaseNotificationToUser($user, $title, $message, MessageType::UNCLASSIFIED);
    }


    /**
     * @throws Exception
     */
    public function sendSuccessfulDepositNotification(User $user, float $amount): void
    {
        $title = config('notifications.successful_deposit_confirmation.title');
        $bodyTemplate = config('notifications.successful_deposit_confirmation.message');

        $formattedAmount = $this->formatAmount($amount);

        $message = str_replace('{amount}', $formattedAmount . " VND", $bodyTemplate);

        $isDriver = $user->roles->contains('name', $this->getRoleDriver());
        $driver = $this->driverRepository->findByField('user_id', $user->id);

        if ($isDriver) {
            $this->sendFirebaseNotificationToDriver($driver, $title, $message);
        } else {
            $this->sendFirebaseNotificationToUser($user, $title, $message);
        }


    }

    public function formatAmount(float $amount): string
    {
        return number_format($amount, 0, ',', '.');
    }

    /**
     * @throws Exception
     */
    public function sendSuccessfulWithdrawalNotification(User $user, float $amount): void
    {
        $title = config('notifications.successful_withdrawal_confirmation.title');
        $bodyTemplate = config('notifications.successful_withdrawal_confirmation.message');

        $formattedAmount = $this->formatAmount($amount);
        $message = str_replace('{amount}', $formattedAmount . " VND", $bodyTemplate);

        $isDriver = $user->roles->contains('name', $this->getRoleDriver());
        $driver = $this->driverRepository->findByField('user_id', $user->id);

        if ($isDriver) {
            $this->sendFirebaseNotificationToDriver($driver, $title, $message);
        } else {
            $this->sendFirebaseNotificationToUser($user, $title, $message);
        }
    }

    /**
     * @throws Exception
     */
    public function sendSuccessfulPaymentNotification(User $user, float $amount): void
    {
        $title = config('notifications.successful_payment_confirmation.title');
        $bodyTemplate = config('notifications.successful_payment_confirmation.message');
        $formattedAmount = $this->formatAmount($amount);
        $message = str_replace('{amount}', $formattedAmount . " VND", $bodyTemplate);
        $isDriver = $user->roles->contains('name', $this->getRoleDriver());
        $driver = $this->driverRepository->findByField('user_id', $user->id);

        if ($isDriver) {
            $this->sendFirebaseNotificationToDriver($driver, $title, $message, MessageType::PAYMENT);
        } else {
            $this->sendFirebaseNotificationToUser($user, $title, $message, MessageType::PAYMENT);
        }
    }

    /**
     * @throws Exception
     */
    public function sendOrderCompletedNotification(float $amount, $order): void
    {
        $title = config('notifications.order_completed_success.title');
        $bodyTemplate = config('notifications.order_completed_success.message');
        $formattedAmount = $this->formatAmount($amount);
        $message = str_replace(['{amount}', '{order_code}'], [$formattedAmount . " VND", $order->code], $bodyTemplate);
        $driver = $order->driver;
        $this->sendFirebaseNotificationToDriver($driver, $title, $message, MessageType::PAYMENT);
    }

    public function sendOrderHoldNotification(User $user, Order $order): void
    {
        $title = config('notifications.order_hold_confirmation.title');
        $bodyTemplate = config('notifications.order_hold_confirmation.message');
        $formattedAmount = $this->formatAmount($order->advance_payment_amount);
        $message = str_replace(['{amount}', '{order_code}'], [$formattedAmount . " VND", $order->code], $bodyTemplate);
        $this->sendFirebaseNotificationToUser($user, $title, $message, MessageType::TEMPORARY_HOLD);

    }

    public function sendDriverWantsToTakeOrderNotification(User $user, Order $order): void
    {
        $title = config('notifications.driver_wants_to_take_order.title');
        $bodyTemplate = config('notifications.driver_wants_to_take_order.message');
        $driverName = $order->driver->user->fullname;
        $message = str_replace(
            ['{driver_name}', '{order_code}'],
            [$driverName, $order->code],
            $bodyTemplate
        );
        $this->sendFirebaseNotificationToUser($user, $title, $message, MessageType::UNCLASSIFIED);
    }

    /**
     * @throws Exception
     */
    public function getNotifications(Request $request)
    {
        $data = $request->validated();

        $userId = $this->getCurrentUserId();
        $driverId = $this->getCurrentDriverId();

        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;

        if ($driverId) {
            return $this->repository->getNotificationById('driver_id', $driverId, $page, $limit);
        } else {
            return $this->repository->getNotificationById('user_id', $userId, $page, $limit);
        }
    }

    public function detail($id)
    {
        return $this->repository->detail($id);
    }

    public function markAsRead($id)
    {
        return $this->repository->markAsRead($id);
    }


    public function completedOrder(User $user, Order $order): void
    {
        $title_user = config('notifications.completedOrder_user.title');
        $message_user = config('notifications.completedOrder_user.message');


        $title_user = str_replace('{order_code}', $order->code, $title_user);
        $message_user = str_replace('{order_code}', $order->code, $message_user);


        $this->sendFirebaseNotificationToUser($order->user, $title_user, $message_user, MessageType::UNCLASSIFIED);

    }


}

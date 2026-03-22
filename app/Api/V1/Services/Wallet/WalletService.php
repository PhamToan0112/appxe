<?php

namespace App\Api\V1\Services\Wallet;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\Wallet\WalletRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Notification\MessageType;
use App\Enums\Transaction\TransactionType;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use App\Traits\UseLog;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{
    use AuthServiceApi, UseLog;

    protected array $data;

    protected WalletRepositoryInterface $repository;

    protected NotificationServiceInterface $notificationService;

    protected NotificationRepositoryInterface $notificationRepository;

    protected FileService $fileService;

    protected AdminRepositoryInterface $adminRepository;

    protected TransactionRepositoryInterface $transactionRepository;


    public function __construct(
        WalletRepositoryInterface       $repository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationServiceInterface    $notificationService,
        AdminRepositoryInterface        $adminRepository,
        TransactionRepositoryInterface  $transactionRepository,
        FileService                     $fileService
    )
    {
        $this->repository = $repository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->fileService = $fileService;
        $this->adminRepository = $adminRepository;
        $this->transactionRepository = $transactionRepository;

    }

    public function getBalance()
    {
        try {
            $user = $this->getCurrentUser();
            if ($user && isset($user->wallet)) {
                $balance = (double)$user->wallet->balance;
                return $balance;
            } else {
                throw new Exception('User or wallet not found');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    public function checkBalance(Request $request): bool
    {
        $data = $request->validated();
        $total = (double)$data['total'];
        $user = $this->getCurrentUser();
        $balance = (double)$user->wallet->balance;
        if ($balance < $total) {
            throw new BadRequestException("Số dư không đủ");
        } else {
            return true;
        }
    }


    /**
     * @throws Exception
     */
    public function deposit(Request $request): object|bool
    {
        $data = $request->validated();
        $driverId = $this->getCurrentDriverId();
        $userId = $this->getCurrentUserId();
        $title = config('notifications.request_deposit_confirmation.title');
        $message = config('notifications.request_deposit_confirmation.message');

        $notificationData = [
            'type' => MessageType::DEPOSIT,
            'title' => $title,
            'message' => $message,
            'user_id' => $userId,
        ];

        if ($driverId) {
            $notificationData['driver_id'] = $driverId;
            unset($notificationData['user_id']);
        }

        try {
            DB::beginTransaction();

            if (isset($data['confirmation_image'])) {
                $avatar = $data['confirmation_image'];
                $notificationData['confirmation_image'] = $this->fileService->uploadAvatar('images/wallets', $avatar);
            }

            $notification = $this->notificationRepository->create($notificationData);
            $this->notificationService->sendNotificationsToAdmins($title, $message, MessageType::DEPOSIT, true);

            DB::commit();

            return $notification;

        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Error creating deposit notification", $e);
            return false;
        }
    }

    public function withdraw(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $driverId = $this->getCurrentDriverId();
            $userId = $this->getCurrentUserId();
            $title = config('notifications.request_withdrawal_confirmation.title');
            $message = config('notifications.request_withdrawal_confirmation.message');

            $notificationData = [
                'type' => MessageType::WITHDRAW,
                'title' => $title,
                'message' => $message,
                'user_id' => $userId,
                'bank_id' => $data['bank_id'],
                'amount' => $data['amount'],
                'bank_account_number' => $data['bank_account_number'],
            ];

            if ($driverId) {
                $notificationData['driver_id'] = $driverId;
                unset($notificationData['user_id']);
            }
            $notification = $this->notificationRepository->create($notificationData);
            $this->notificationService->sendNotificationsToAdmins($title, $message, MessageType::WITHDRAW, true);
            DB::commit();

            return $notification;

        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Error withdrawing funds", $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function deductAmount(float $amount, $userId): void
    {
        $wallet = $this->repository->findByField('user_id', $userId);
        $user = $wallet->user;
        $wallet->balance -= $amount;
        $wallet->save();
        $this->notificationService->sendSuccessfulPaymentNotification($user, $amount);
        $type = TransactionType::Payment->value;
        $this->transactionRepository->create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => $type,
            'code' => uniqid_real(8)
        ]);
    }

    public function deductAmountSilently(float $amount, $userId): void
    {
        $wallet = $this->repository->findByField('user_id', $userId);
        $wallet->balance -= $amount;
        $wallet->save();

    }

    /**
     * @param float $amount
     * @param int $userId
     * @param Order|null $order
     * @throws Exception
     */
    public function addFunds(float $amount, int $userId, Order|null $order): void
    {
        $wallet = $this->repository->findByField('user_id', $userId);
        $wallet->balance += $amount;
        $wallet->save();
        $this->notificationService->sendOrderCompletedNotification($amount, $order);
        $type = TransactionType::Payment->value;
        $this->transactionRepository->create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => $type,
            'code' => uniqid_real(8)
        ]);
    }


}

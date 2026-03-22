<?php

namespace App\Admin\Services\Wallet;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Repositories\Wallet\WalletRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Enums\Transaction\TransactionType;
use App\Traits\WalletOperations;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WalletService implements WalletServiceInterface
{
    use UseLog, Roles, Response, WalletOperations;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected WalletRepositoryInterface $repository;

    protected TransactionRepositoryInterface $transactionRepository;


    protected DriverRepositoryInterface $driverRepository;

    protected NotificationServiceInterface $notificationService;

    public function __construct(
        WalletRepositoryInterface      $repository,
        DriverRepositoryInterface      $driverRepository,
        TransactionRepositoryInterface $transactionRepository,
        NotificationServiceInterface   $notificationService
    )
    {

        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
        $this->transactionRepository = $transactionRepository;
        $this->notificationService = $notificationService;

    }


    public function deposit(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $amount = $data['amount'];
            $wallet = $this->handleDeposit($data['wallet_id'], $amount);
            $user = $wallet->user;

            $transaction = $this->transactionRepository->create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => TransactionType::Deposit,
                'code' => uniqid_real(8),
            ]);

            DB::commit();
            $this->notificationService->sendSuccessfulDepositNotification($user, $amount);
            return $this->jsonResponseSuccess($transaction);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process deposit', $e);
            return $this->jsonResponseError("Có lỗi xảy ra trong quá trình nạp tiền", 500);
        }
    }

    /**
     * @throws Exception
     */
    public function getBalance(Request $request): JsonResponse
    {
        $data = $request->validated();
        $wallet = $this->repository->findOrFail($data['wallet_id']);
        return $this->jsonResponseSuccess($wallet);
    }

    public function withdraw(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $amount = $data['amount'];
            $wallet = $this->handleWithdraw($data['wallet_id'], $amount);
            $user = $wallet->user;

            $transaction = $this->transactionRepository->create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => TransactionType::Withdraw,
                'code' => uniqid_real(8),
            ]);

            DB::commit();
            $this->notificationService->sendSuccessfulWithdrawalNotification($user, $amount);
            return $this->jsonResponseSuccess($transaction);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process withdrawal', $e);
            return $this->jsonResponseError("Có lỗi xảy ra trong quá trình rút tiền", 500);
        }
    }

}

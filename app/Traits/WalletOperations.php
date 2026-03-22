<?php

namespace App\Traits;


use App\Admin\Repositories\Wallet\WalletRepositoryInterface;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Support\Response;
use Exception;
use Illuminate\Support\Facades\DB;

trait WalletOperations
{
    use Response;

    /**
     * Handle the deposit process for a wallet.
     *
     * @param int $walletId
     * @param float $amount
     * @throws Exception
     */
    public function handleDeposit(int $walletId, float $amount)
    {
        $walletRepository = app(WalletRepositoryInterface::class);

        DB::beginTransaction();

        try {
            $wallet = $walletRepository->findOrFail($walletId);

            $wallet->balance += $amount;

            $response = $walletRepository->update($wallet->id, ['balance' => $wallet->balance]);

            DB::commit();
            return $response;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error deposit for wallet", $e);
            throw new Exception('Failed to process deposit: ' . $e->getMessage());
        }
    }

    /**
     * Handle the withdraw process for a wallet.
     *
     * @param int $walletId
     * @param float $amount
     * @throws Exception
     */
    public function handleWithdraw(int $walletId, float $amount)
    {
        $walletRepository = app(WalletRepositoryInterface::class);
        $wallet = $walletRepository->findOrFail($walletId);

        if ($wallet->balance < $amount) {
            throw new BadRequestException("Số dư không đủ để rút tiền");
        }

        $wallet->balance -= $amount;

        return $walletRepository->update($wallet->id, ['balance' => $wallet->balance]);
    }
}

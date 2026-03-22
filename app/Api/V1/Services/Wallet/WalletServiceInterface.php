<?php

namespace App\Api\V1\Services\Wallet;

use App\Models\Order;
use Illuminate\Http\Request;

interface WalletServiceInterface
{
    public function checkBalance(Request $request);

    public function deposit(Request $request);

    public function withdraw(Request $request);

    public function deductAmount(float $amount, $userId);

    public function deductAmountSilently(float $amount, $userId);

    /**
     * Add funds to a user's wallet and possibly associate the transaction with an order.
     *
     * @param float $amount Amount to be added.
     * @param int $userId ID of the user to whom the funds will be added.
     * @param Order|null $order Optional order associated with the transaction.
     * @return void
     */
    public function addFunds(float $amount, int $userId, ?Order $order): void;

}

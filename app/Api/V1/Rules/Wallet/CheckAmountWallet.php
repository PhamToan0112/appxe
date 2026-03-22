<?php

namespace App\Api\V1\Rules\Wallet;

use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Contracts\Validation\Rule;

class CheckAmountWallet implements Rule
{
    use AuthServiceApi;

    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }


    public function passes($attribute, $value): bool
    {
        $user = $this->getCurrentUser();

        $wallet = $user->wallet;

        return $wallet->balance >= $this->amount;
    }

    public function message(): string
    {
        return "Số dư của bạn không đủ";
    }
}

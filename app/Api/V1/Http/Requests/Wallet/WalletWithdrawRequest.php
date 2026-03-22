<?php

namespace App\Api\V1\Http\Requests\Wallet;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Wallet\CheckAmountWallet;

class WalletWithdrawRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPost(): array
    {
        return [
            'amount' => ['required', 'numeric', new CheckAmountWallet($this->input('amount'))],
            'bank_account_number' => ['required', 'string'],
            'bank_id' => ['required', 'exists:banks,id'],
        ];
    }
}

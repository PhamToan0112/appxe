<?php

namespace App\Admin\Http\Requests\Transaction;

use App\Admin\Http\Requests\BaseRequest;


class DepositTransactionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [

            'amount' => ['required'],
            'wallet_id' => ['required', 'exists:wallets,id'],
        ];
    }


}

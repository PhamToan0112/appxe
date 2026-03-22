<?php

namespace App\Admin\Http\Requests\Wallet;

use App\Admin\Http\Requests\BaseRequest;


class WalletRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'wallet_id' => ['required', 'exists:wallets,id'],
        ];
    }


}

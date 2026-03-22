<?php

namespace App\Api\V1\Http\Requests\Wallet;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Currency\Currency;

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
            'user_id' => [ 'exists:users,id'], 
            'balance' => [ 'numeric'],
            'currency' => [ Currency::getValues()],
            'status' => ['nullable', 'string']
        ];
    }
}

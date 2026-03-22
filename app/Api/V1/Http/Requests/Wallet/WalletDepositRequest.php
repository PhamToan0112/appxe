<?php

namespace App\Api\V1\Http\Requests\Wallet;

use App\Api\V1\Http\Requests\BaseRequest;

class WalletDepositRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPost(): array
    {
        return [
            'confirmation_image' => ['required']

        ];
    }
}

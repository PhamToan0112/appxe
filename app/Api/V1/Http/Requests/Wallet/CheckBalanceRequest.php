<?php

namespace App\Api\V1\Http\Requests\Wallet;

use App\Api\V1\Http\Requests\BaseRequest;

class CheckBalanceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodGet(): array
    {
        return [
            'total' => ['required']
        ];
    }
}

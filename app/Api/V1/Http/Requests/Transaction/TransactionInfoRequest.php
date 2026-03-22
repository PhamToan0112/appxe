<?php

namespace App\Api\V1\Http\Requests\Transaction;

use App\Api\V1\Http\Requests\BaseRequest;

class TransactionInfoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'code' => ['required', 'string', 'exists:transactions,code'],
        ];
    }
}

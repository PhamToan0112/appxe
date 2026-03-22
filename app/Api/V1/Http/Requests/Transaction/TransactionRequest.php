<?php

namespace App\Api\V1\Http\Requests\Transaction;

use App\Api\V1\Http\Requests\BaseRequest;

class TransactionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],
            'type' => ['nullable', 'string'],
        ];
    }
}

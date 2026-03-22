<?php

namespace App\Admin\Http\Requests\Transaction;
use App\Enums\Transaction\TransactionType;
use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut(): array
    {   
        return [
            'id' => ['required', 'exists:App\Models\Transaction,id'],
            'type' => ['nullable', new Enum(TransactionType::class)],
            'code' => ['nullable', 'string'],
        ];
    }
}

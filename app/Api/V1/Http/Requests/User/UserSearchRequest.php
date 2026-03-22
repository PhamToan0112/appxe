<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;

class UserSearchRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPost(): array
    {
        return [
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'order_type' => ['required',],

        ];
    }
}

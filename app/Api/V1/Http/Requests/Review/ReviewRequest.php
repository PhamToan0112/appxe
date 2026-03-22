<?php

namespace App\Api\V1\Http\Requests\Review;

use App\Api\V1\Http\Requests\BaseRequest;

class ReviewRequest extends BaseRequest
{

    protected function methodPost(): array
    {
        return [
            'order_id' => ['required', 'exists:App\Models\Order,id'],
            'rating' => ['required'],
            'content' => ['required', 'string'],
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\User,id'],
            'rating' => ['nullable'],
            'content' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable']
        ];
    }
}

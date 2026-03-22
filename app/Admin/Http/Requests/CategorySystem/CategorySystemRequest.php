<?php

namespace App\Admin\Http\Requests\CategorySystem;

use App\Admin\Http\Requests\BaseRequest;

class CategorySystemRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'avatar' => ['required'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\CategorySystem,id'],
            'name' => ['required', 'string'],
            'avatar' => ['required'],
            'status' => ['required'],
        ];
    }
}
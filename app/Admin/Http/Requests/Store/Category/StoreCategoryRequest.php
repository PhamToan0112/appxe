<?php

namespace App\Admin\Http\Requests\Store\Category;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\DefaultStatus;
use Illuminate\Validation\Rules\Enum;

class StoreCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string'],
            'position' => ['required', 'integer'],
            'status' => ['required', new Enum(DefaultStatus::class)]
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\StoreCategory,id'],
            'name' => ['required', 'string'],
            'position' => ['nullable', 'integer'],
            'status' => ['required', new Enum(DefaultStatus::class)]
        ];
    }
}

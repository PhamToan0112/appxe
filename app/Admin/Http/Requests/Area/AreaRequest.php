<?php

namespace App\Admin\Http\Requests\Area;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Area\AreaStatus;
use Illuminate\Validation\Rules\Enum;

class AreaRequest extends BaseRequest
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
            'position' => ['nullable', 'integer'],
            'status' => ['required', new Enum(AreaStatus::class)],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'address' => ['required'],
            'fee' => ['required'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Area,id'],
            'name' => ['required', 'string'],
            'position' => ['nullable', 'integer'],
            'status' => ['required', new Enum(AreaStatus::class)],
            'peak_status' => ['required', new Enum(AreaStatus::class)],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'address' => ['required'],
            'fee' => ['required'],
        ];
    }
}

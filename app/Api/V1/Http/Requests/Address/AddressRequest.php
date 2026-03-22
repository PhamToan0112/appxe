<?php

namespace App\Api\V1\Http\Requests\Address;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Address\AddressType;
use App\Enums\Address\AddressDefaultStatus;
use Illuminate\Validation\Rules\Enum;

class AddressRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => ['required', new Enum(AddressType::class)],
            'default_status' => ['nullable', new Enum(AddressDefaultStatus::class)],
        ];
    }
    protected function methodPut(): array
    {
        return [
            'name' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => ['nullable', new Enum(AddressType::class)],
            'default_status' => ['nullable', new Enum(AddressDefaultStatus::class)]
        ];
    }
}

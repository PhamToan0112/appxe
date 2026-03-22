<?php

namespace App\Admin\Http\Requests\Route;

use App\Admin\Http\Requests\BaseRequest;

class RouteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'start_address' => ['required'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'end_address' => ['required'],
            'end_lat' => ['nullable', 'numeric'],
            'end_lng' => ['nullable', 'numeric'],
            'driver_id' => ['required', 'exists:App\Models\Driver,id'],
            'price' => 'required',
            'return_price' => 'required'

        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Route,id'],
            'start_address' => ['required'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'end_address' => ['required'],
            'end_lat' => ['nullable', 'numeric'],
            'end_lng' => ['nullable', 'numeric'],
            'price' => 'required',
            'return_price' => 'required'
        ];
    }
}
<?php

namespace App\Api\V1\Http\Requests\Route;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Order\TripType;
use Illuminate\Validation\Rules\Enum;

class RouteRequest extends BaseRequest
{

    protected function methodGet(): array
    {
        return [
            'start_address' => ['required', 'string'],
            'end_address' => ['required', 'string'],
            'type' => ['required', new Enum(TripType::class)],

        ];
    }

    public function methodPost(): array
    {
        return [
            'start_address' => ['required', 'string', 'max:255'],
            'end_address' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'return_price' => ['nullable', 'numeric'],
            'departure_time' => ['required', 'date_format:H:i:s'],

        ];
    }
}

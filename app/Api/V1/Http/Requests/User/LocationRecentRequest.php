<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Order\OrderType;
use Illuminate\Validation\Rules\Enum;


class LocationRecentRequest extends BaseRequest
{
    use AuthServiceApi;


    protected function methodGet(): array
    {
        return [
            'type' => ['required', new Enum(OrderType::class)],
        ];
    }
}

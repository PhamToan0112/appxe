<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\OrderCMultiStatus;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class OrderCMultiRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:orders,id'],
            'user_id' => ['required', 'exists:users,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'status' => ['required', new Enum(OrderCMultiStatus::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required'],
            'platform_fee' => ['required', 'numeric'],
            'distance' => ['nullable'],
            'note' => ['nullable', 'string'],
            'return_image' => ['nullable', 'string'],
            'delivery_date' => ['nullable', 'date'],
            'delivery_time' => ['nullable', 'date_format:H:i'],
            'holiday_fee'=> ['nullable','integer'],
            'night_time_fee'=> ['nullable','integer'],
            'high_point_area_fee'=> ['nullable','integer'],
        ];
    }
}

<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class OrderCRideCarRequest extends BaseRequest
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
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'address' => ['required'],
            'end_lat' => ['required', 'numeric'],
            'end_lng' => ['required', 'numeric'],
            'end_address' => ['required'],
            'status' => ['required', new Enum(OrderStatus::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required'],
            'sub_total' => ['required'],
            'platform_fee' => ['required', 'numeric'],
            'distance' => ['nullable'],
            'note' => ['nullable', 'string'],
            'order_confirmation_image' => ['nullable', 'string'],
            'holiday_fee'=> ['nullable','integer'],
            'night_time_fee'=> ['nullable','integer'],
            'high_point_area_fee'=> ['nullable','integer'],
        ];
    }
}

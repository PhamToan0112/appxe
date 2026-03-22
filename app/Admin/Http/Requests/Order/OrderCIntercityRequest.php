<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class OrderCIntercityRequest extends BaseRequest
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
            'note' => ['nullable', 'string'],
            'discount_amount' => ['nullable', 'numeric'],
            'trip_type' => ['required', new Enum(TripType::class)],
            'start_date' => ['required', 'date'],
            'departure_time' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'return_time' => ['nullable', 'date'],
            'passenger_count' => ['required', 'integer', 'min:1'],
            'reference_price' => ['nullable', 'numeric'],
            'holiday_fee'=> ['nullable','integer'],
            'night_time_fee'=> ['nullable','integer'],
            'high_point_area_fee'=> ['nullable','integer'],
        ];
    }
}

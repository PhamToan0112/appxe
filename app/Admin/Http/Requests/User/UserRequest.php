<?php

namespace App\Admin\Http\Requests\User;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\User\CostStatus;
use App\Enums\User\DiscountSortStatus;
use App\Enums\User\DistanceStatus;
use App\Enums\User\Gender;
use App\Enums\User\RatingSortStatus;
use App\Enums\User\TimeStatus;
use App\Enums\User\UserStatus;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [

            'fullname' => ['required', 'string'],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:App\Models\User,phone'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'password' => ['required', 'string', 'confirmed'],
            'address' => ['nullable'],
            'name' => ['nullable','string'],
            'gender' => ['required', new Enum(Gender::class)],
            'lng' => ['nullable'],
            'lat' => ['nullable'],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
            'avatar' => ['nullable'],
            'bank_account_number' => ['required', 'string'],
            'bank_id' => ['required', 'exists:App\Models\Bank,id'],

        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\User,id'],
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\User,email,' . $this->id],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:App\Models\User,phone,' . $this->id],
            'password' => ['nullable', 'string', 'confirmed'],
            'gender' => ['required', new Enum(Gender::class)],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
            'avatar' => ['nullable'],
            'status' => ['required', new Enum(UserStatus::class)],
            'bank_account_number' => ['required', 'string'],
            'bank_id' => ['required', 'exists:App\Models\Bank,id'],
            'cost_preference' => ['required', new Enum(CostStatus::class)],
            'car_life' => ['required', new Enum(TimeStatus::class)],
            'rating_preference' => ['required', new Enum(RatingSortStatus::class)],
            'discount_preference' => ['required', new Enum(DiscountSortStatus::class)],
            'distance_preference' => ['required', new Enum(DistanceStatus::class)],
            'vehicle_type' => ['required', new Enum(VehicleType::class)],
            'price_setting_c_car' => ['nullable'],

        ];
    }
}

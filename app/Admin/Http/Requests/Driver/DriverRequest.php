<?php

namespace App\Admin\Http\Requests\Driver;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\OpenStatus;
use App\Enums\Service\ServiceStatus;
use App\Enums\User\UserStatus;
use App\Enums\Vehicle\VehicleType;
use App\Models\Driver;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;


class DriverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'area_id' => ['nullable', 'exists:App\Models\Area,id'],
            'id_card' => ['required', 'string', 'unique:drivers,id_card'],
            'license_plate' => ['required', 'string', 'unique:vehicles,license_plate'],
            'license_plate_image' => ['nullable'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'end_address' => ['required'],
            'end_lat' => ['required'],
            'end_lng' => ['required'],
            'emergency_contact_address' => ['required', 'string'],
            'emergency_contact_phone' => ['required', 'string'],
            'emergency_contact_name' => ['required', 'string'],
            'avatar' => 'nullable',
            'auto_accept' => ['nullable ', new Enum(AutoAccept::class)],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'type' => ['required', new Enum(VehicleType::class)],
            'name' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'driver_license_front' => ['required'],
            'driver_license_back' => ['required'],
            'vehicle_front_image' => ['required'],
            'vehicle_back_image' => ['required'],
            'vehicle_side_image' => ['required'],
            'vehicle_interior_image' => ['required'],
            'insurance_front_image' => ['required'],
            'insurance_back_image' => ['required'],
            'amenities' => ['nullable'],
            'description' => ['nullable'],
            'password' => ['required', 'string', 'confirmed'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_info.fullname' => ['required', 'string'],
            'user_info.bank_account_number' => ['required', 'string'],
            'user_info.bank_id' => ['required', 'exists:App\Models\Bank,id'],
            'user_info.phone' => ['required', 'string', 'unique:users,phone'],
            'user_info.email' => ['required', 'string', 'email', 'unique:users,email'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
        ];
    }

    public function driver()
    {
        return Driver::find($this->id);
    }

    protected function methodPut(): array
    {
        $driver = $this->driver();
        $user_id = $driver ? $driver->user_id : null;
        return [
            'area_id' => ['nullable', 'exists:App\Models\Area,id'],
            'id' => ['required', 'exists:App\Models\Driver,id'],
            'id_card' => 'required|string|max:50|unique:drivers,id_card,' . $this->id . ',id',
            'license_plate' => ['nullable', 'string', 'max:20'],
            'license_plate_image' => ['nullable'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'avatar' => 'nullable',
            'min_earning' => ['required'],
            'max_earning' => ['required'],
            'end_address' => ['nullable'],
            'end_lat' => ['nullable'],
            'end_lng' => ['nullable'],
            'emergency_contact_address' => ['required', 'string'],
            'emergency_contact_phone' => ['required', 'string'],
            'emergency_contact_name' => ['required', 'string'],
            'service_start_time' => ['nullable'],
            'service_end_time' => ['nullable'],
            'auto_accept' => ['nullable', new Enum(AutoAccept::class)],
            'order_status' => ['required', new Enum(DriverOrderStatus::class)],
            'service_ride' => ['required', new Enum(ServiceStatus::class)],
            'service_ride_price' => ['nullable'],
            'service_car' => ['required', new Enum(ServiceStatus::class)],
            'service_car_price' => ['nullable'],
            'service_delivery_now' => ['required', new Enum(ServiceStatus::class)],
            'service_delivery_now_price' => ['nullable'],
            'service_delivery_later' => ['required', new Enum(ServiceStatus::class)],
            'delivery_later_fee_per_stop' => ['nullable'],
            'service_intercity' => ['required', new Enum(ServiceStatus::class)],
            'service_intercity_price' => ['nullable'],
            'weightRange' => ['sometimes', 'array'],
            'weightRange.*.id' => ['required', 'exists:shipping_weight_ranges,id'],
            'weightRange.*.price' => ['required', 'numeric', 'min:0'],
            'peak_hour_price' => ['nullable'],
            'night_time_price' => ['nullable'],
            'holiday_price' => ['nullable'],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'driver_license_front' => ['required'],
            'driver_license_back' => ['required'],
            'service_intercity_start_time' => 'nullable|date_format:H:i',
            'service_intercity_end_time' => 'nullable|date_format:H:i',
            'password' => ['nullable', 'string', 'confirmed'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_info.fullname' => ['required', 'string'],
            'user_info.bank_account_number' => ['required', 'string'],
            'user_info.bank_id' => ['required', 'exists:App\Models\Bank,id'],
            'status' => ['required', new Enum(UserStatus::class)],
            'is_verified' => ['required', new Enum(VerificationStatus::class)],
            'user_info.active' => ['required', new Enum(OpenStatus::class)],
            'user_info.phone' => [
                'required',
                'string',
                Rule::unique('users', 'phone')->ignore($user_id, 'id'),
            ],
            'user_info.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user_id, 'id')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.unique' => __('This user has already registered as a driver.'),
            'user_info.phone.unique' => __('exist_phone'),
            'user_info.email.unique' => __('exist_email'),
            'weightRange.*.price.required' => __('A price must be provided for each weight range.'),
            'weightRange.*.price.numeric' => __('The price must be a numeric value.'),
            'weightRange.*.price.min' => __('The price must be at least zero.'),
        ];
    }
}

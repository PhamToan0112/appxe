<?php

namespace App\Api\V1\Http\Requests\Driver;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Driver\AutoAccept;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class DriverUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    use AuthServiceApi;
    protected function methodPost(): array
    {
        $driver = $this->getCurrentDriver();
        return [
            //userinfo
            'fullname' => ['nullable', 'string'],
            'email' => [
                'nullable',
                Rule::unique('users', 'email')->ignore($this->user()->id, 'id')
            ],
            'phone' => [
                'nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                Rule::unique('users', 'phone')->ignore($this->user()->id, 'id')
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
            'birthday' => ['nullable'],

            //driverinfo
            'id_card' => [
                'nullable', 'string', 'regex:/^\d{12}$/',
                Rule::unique('drivers', 'id_card')->ignore($driver->id, 'id')
            ],
            'license_plate' => [
                'nullable', 'string',
                Rule::unique('vehicles', 'license_plate')->ignore($driver->vehicle->id, 'id')
            ],
            'id_card_front' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'id_card_back' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'license_plate_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'driver_license_front' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'driver_license_back' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'bank_name' => ['nullable', 'string'],
            'bank_account_name' => ['nullable', 'string'],
            'bank_account_number' => ['nullable', 'string', 'max:20'],
            'current_address' => ['nullable'],
            'current_lat' => ['nullable'],
            'current_lng' => ['nullable'],
            'auto_accept' => ['nullable ', new Enum(AutoAccept::class)],

            //vehicleinfo
            'vehicle_company' => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'vehicle_registration_front' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_registration_back' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_front_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_back_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_side_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_interior_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'insurance_front_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'insurance_back_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'color' => ['nullable', 'string'],
            'seat_number' => ['nullable', 'integer'],
            'type' => ['nullable', new Enum(VehicleType::class)],
            'vehicle_line_id' => ['required', 'exists:vehicle_lines,id'],

        ];
    }
}

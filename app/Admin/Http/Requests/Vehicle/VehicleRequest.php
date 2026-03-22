<?php

namespace App\Admin\Http\Requests\Vehicle;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Vehicle\{VehicleType, VehicleStatus, LicensePlateColor};
use App\Enums\Order\OrderType;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class VehicleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string'],
            'color' => ['required', 'string'],
            'production_year' => ['required', 'integer'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => ['required', 'string', 'unique:vehicles,license_plate'],
            'license_plate_color' => ['required', new Enum(LicensePlateColor::class)],
            'type' => ['required', new Enum(VehicleType::class)],
            'status' => ['required', new Enum(VehicleStatus::class)],

            'service_type' => ['required', 'array'], 

            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'vehicle_front_image' => ['nullable'],
            'vehicle_back_image' => ['nullable'],
            'vehicle_side_image' => ['nullable'],
            'vehicle_interior_image' => ['nullable'],
            'insurance_front_image' => ['nullable'],
            'insurance_back_image' => ['nullable'],
            'avatar' => ['nullable'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'vehicle_line_id' => ['required', 'exists:vehicle_lines,id'],
        ];
    }


    public function vehicle()
    {
        return Vehicle::find($this->id);
    }

    protected function methodPut(): array
    {
        $vehicle = $this->vehicle();
        return [
            'id' => ['required', 'exists:App\Models\Vehicle,id'],
            'name' => ['required', 'string'],
            'color' => ['required', 'string'],
            'production_year' => ['required', 'integer'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => [
                'nullable',
                'string',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id)
            ],
            'type' => ['required', new Enum(VehicleType::class)],
            'license_plate_color' => ['required', new Enum(LicensePlateColor::class)],
            'status' => ['required', new Enum(VehicleStatus::class)],
            'avatar' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'vehicle_front_image' => ['nullable'],
            'vehicle_back_image' => ['nullable'],
            'vehicle_side_image' => ['nullable'],
            'vehicle_interior_image' => ['nullable'],
            'insurance_front_image' => ['nullable'],
            'insurance_back_image' => ['nullable'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
            'driver_id' => ['required', 'exists:drivers,id'],
            'vehicle_line_id' => ['required', 'exists:vehicle_lines,id'],

            'service_type' => ['required', 'array'], 
        ];
    }
}

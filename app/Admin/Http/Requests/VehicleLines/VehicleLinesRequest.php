<?php

namespace App\Admin\Http\Requests\VehicleLines;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\VehicleLines;

class VehicleLinesRequest extends BaseRequest
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
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer']
        ];
    }


    public function vehicleLines()
    {
        return VehicleLines::find($this->id);
    }

    protected function methodPut(): array
    {
        $vehicleLines = $this->vehicleLines();
        return [
            'id' => ['required', 'exists:App\Models\VehicleLines,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer']
        ];
    }
}

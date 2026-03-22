<?php 
namespace App\Admin\Http\Requests\Holiday; 

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\DefaultStatus;
use Illuminate\Validation\Rules\Enum;

class HolidayRequest extends BaseRequest
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
            'date' => ['required', 'date'],
            'status' => ['required', new Enum(DefaultStatus::class)],
        ];
    }
    protected function methodGet(): array
    {
        return [
           'name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', new Enum(DefaultStatus::class)],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Holiday,id'],
            'name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', new Enum(DefaultStatus::class)],
        ];
    }
}
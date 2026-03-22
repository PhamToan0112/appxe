<?php 
namespace App\Admin\Http\Requests\Address; 

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Address\AddressType;
use Illuminate\Validation\Rules\Enum;

class AddressRequest extends BaseRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'name' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'type' => ['required', new Enum(AddressType::class)],
        ];
    }
    protected function methodGet(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'name' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'type' => ['required', new Enum(AddressType::class)],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Address,id'],
            'user_id' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'name' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'type' => ['required', new Enum(AddressType::class)],
        ];
    }
}
<?php 
namespace App\Admin\Http\Requests\Category;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class CategoryRequest extends BaseRequest
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
            'status' => ['required', new Enum(ActiveStatus::class)],
        ];
    }

    protected function methodGet(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Category,id'],
            'status' => ['required', new Enum(ActiveStatus::class)],

        ];
    }
    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', new Enum(ActiveStatus::class)],
        ];
    }
}
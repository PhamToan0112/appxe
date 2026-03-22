<?php

namespace App\Admin\Http\Requests\WeighRange;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Area\AreaStatus;
use Illuminate\Validation\Rules\Enum;

class WeightRangeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'min_weight' => ['required', 'integer'],
            'max_weight' => ['required', 'integer'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\WeightRange,id'],
            'min_weight' => ['required', 'integer'],
            'max_weight' => ['required', 'integer'],
        ];
    }
}

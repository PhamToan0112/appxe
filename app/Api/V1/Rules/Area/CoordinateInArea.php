<?php

namespace App\Api\V1\Rules\Area;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class CoordinateInArea implements Rule
{

    protected $areas;

    public function __construct($areas)
    {
        $this->areas = $areas;
    }


    public function passes($attribute, $value): bool
    {
        foreach ($this->areas as $area) {
            try {
                if (isCoordinateInArea($value['lat'], $value['lng'], json_decode($area->boundaries, true))) {
                    return true;
                }
            } catch (Exception $e) {
                continue;
            }
        }
        return false;
    }

    public function message(): string
    {
        return "Địa điểm nằm ngoài khu vực cho phép.";
    }
}

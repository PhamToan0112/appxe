<?php

namespace App\Api\V1\Http\Resources\Discount;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type,
            'discount_value' => $this->discount_value,
            'percent_value' => $this->percent_value,
            'description' => $this->description,
            'date_start' => format_datetime($this->date_start),
            'date_end' => format_datetime($this->date_end),
        ];
    }
}
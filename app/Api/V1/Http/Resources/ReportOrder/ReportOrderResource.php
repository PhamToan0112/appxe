<?php

namespace App\Api\V1\Http\Resources\ReportOrder;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;

class ReportOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'driver' => optional($this->order->driver->user)->fullname,
            'description' => $this->description,
        ];
    }
}

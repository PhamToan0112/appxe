<?php

namespace App\Admin\Http\Resources\Area;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AreaSearchSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->name
        ];
    }
}

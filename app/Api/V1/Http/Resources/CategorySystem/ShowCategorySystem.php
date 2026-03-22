<?php

namespace App\Api\V1\Http\Resources\CategorySystem;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface;

class ShowCategorySystemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,

        ];
    }
}
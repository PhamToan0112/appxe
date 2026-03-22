<?php

namespace App\Api\V1\Http\Resources\CategorySystem;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class AllCategorySystemResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($category_system) {

            return [
                'id' => $category_system->id,
                'name' => $category_system->name,
                'avatar' => $category_system->avatar
            ];

        });
    }
}

<?php

namespace App\Api\V1\Http\Resources\Category;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class AllCategoryTreeResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function($category){

            return $this->recursive($category);

        });
    }

    private function recursive($category): array
    {
        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'avatar' => $category->avatar
        ];
        if($category->children && $category->children->count() > 0){
            $data['children'] = $category->children->map(function($category){
                return $this->recursive($category);
            });
        }
        return $data;
    }
}

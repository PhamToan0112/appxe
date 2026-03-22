<?php

namespace App\Api\V1\Http\Resources\Post;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class AllPostResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($post) {

            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'image' => asset($post->image),
                'is_featured' => $post->is_featured,
                'excerpt' => $post->excerpt,
                'posted_at' => format_datetime($post->posted_at),
            ];

        });
    }


}

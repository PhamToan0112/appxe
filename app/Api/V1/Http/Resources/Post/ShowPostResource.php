<?php

namespace App\Api\V1\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => asset($this->image),
            'is_featured' => $this->is_featured,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'posted_at' => format_datetime($this->posted_at),
        ];
    }
}

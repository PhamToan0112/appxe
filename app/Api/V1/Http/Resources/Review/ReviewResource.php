<?php 
namespace App\Api\V1\Http\Resources\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'fullname' => optional($this->driver->user)->fullname, 
            'avatar' => asset(optional($this->driver->user)->avatar),
            'content' => $this->content,
            'rating' => $this->rating,
            
        ];
    }
}

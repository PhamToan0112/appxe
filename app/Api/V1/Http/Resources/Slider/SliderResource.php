<?php

namespace App\Api\V1\Http\Resources\Slider;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'name' => $this->name,
            'desc' => $this->desc,
            'items' => $this->items->map(function($item){
                return [
                    'title' => $item->title,
                    'link' => $item->link,
                    'image' => asset($item->image),
                    'mobile_image' => asset($item->mobile_image)
                ];
            })
        ];
    }
}

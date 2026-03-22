<?php

namespace App\Api\V1\Http\Resources\Discount;


use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscountResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'discounts' => $this->collection->map(function ($item) {
                return new DiscountApplicationResource($item);
            }),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'limit' => $this->perPage(),
                'total' => $this->total(),
                'count' => $this->count(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}

<?php

namespace App\Api\V1\Http\Requests\Order;


use App\Api\V1\Http\Resources\Order\CRideCar\OrderCRideCarResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'orders' => $this->collection->map(function ($item) {
                return new OrderCRideCarResource($item);
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

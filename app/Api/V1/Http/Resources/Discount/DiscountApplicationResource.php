<?php

namespace App\Api\V1\Http\Resources\Discount;

use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Services\Discount\DiscountServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountApplicationResource extends JsonResource
{
    use AuthServiceApi;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $discountService = app(DiscountServiceInterface::class);
        $orderRepository = app(OrderRepositoryInterface::class);
        $subTotal = $request->input('sub_total', null);
        $userId = $this->getCurrentUserId();
        $discountId = $this->discount->id;
        $existingOrders = $orderRepository->getBy(
        [
            'user_id' => $userId,
            'discount_id' => $discountId
        ]
    );

        $result = [
            'id' => $this->id,
            'discount' => new DiscountResource($this->discount),

        ];
        if ($existingOrders->first()) {
            $result['check'] = 'USED';
        } else {
            if ($subTotal !== null) {
                $result['check'] = $discountService->isEligible($this->discount, $subTotal) ? 'ACTIVE' : 'INACTIVE';
            }
        }
        return $result;
    }
}

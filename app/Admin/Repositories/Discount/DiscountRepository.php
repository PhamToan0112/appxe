<?php

namespace App\Admin\Repositories\Discount;
use App\Admin\Repositories\EloquentRepository;
use App\Models\Discount;

class DiscountRepository extends EloquentRepository implements DiscountRepositoryInterface
{
    public function getModel(): string
    {
        return Discount::class;
    }


    public function getDriverDiscount($driverId)
    {
        return $this->model->whereHas('discount_applications', function ($query) use ($driverId) {
            $query->where('driver_id', $driverId);
        });
    }

    public function getApplyDiscount($discountId)
    {
        return $this->model
            ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
            ->leftJoin('users', 'discount_applications.user_id', '=', 'users.id')
            ->leftJoin('drivers', 'discount_applications.driver_id', '=', 'drivers.id')
            ->where('discounts.id', $discountId)
            ->select(
                'discounts.*',
                'discount_applications.user_id',
                'discount_applications.driver_id',
            );
    }


}

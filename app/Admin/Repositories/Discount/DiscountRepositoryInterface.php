<?php

namespace App\Admin\Repositories\Discount;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface DiscountRepositoryInterface extends EloquentRepositoryInterface
{
    public function getDriverDiscount($driverId);
    public function getApplyDiscount($discountId);
}

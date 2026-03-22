<?php

namespace App\Api\V1\Repositories\Discount;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface DiscountRepositoryInterface extends EloquentRepositoryInterface
{

    public function checkDiscountApplied($filter): bool;
    public function findByCode($code);
    public function getByDriverId($driverId);
}

<?php

namespace App\Admin\Repositories\Discount;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DiscountApplicationRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByActive($filter, $limit, $page);

}
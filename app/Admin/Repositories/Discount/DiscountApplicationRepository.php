<?php

namespace App\Admin\Repositories\Discount;
use App\Admin\Repositories\EloquentRepository;
use App\Models\DiscountApplication;

class DiscountApplicationRepository extends EloquentRepository implements DiscountApplicationRepositoryInterface
{
    public function getModel(): string
    {
        return DiscountApplication::class;
    }


    public function findByActive($filter, $limit, $page)
    {
        return $this->model->whereHas('discount', function ($query) {
            $query->active();
        })
            ->where($filter)
            ->paginate($limit, ['*'], 'page', $page);
    }

}

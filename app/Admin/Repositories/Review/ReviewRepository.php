<?php

namespace App\Admin\Repositories\Review;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Review;

class ReviewRepository extends EloquentRepository implements ReviewRepositoryInterface
{
    protected $select = [];

    public function getModel()
    {
        return Review::class;
    }

    public function getReviews($id)
    {
        return $this->model->where('driver_id', $id);
    }

}

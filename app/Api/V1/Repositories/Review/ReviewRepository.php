<?php

namespace App\Api\V1\Repositories\Review;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;
use App\Models\Review;

class ReviewRepository extends EloquentRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return Review::class;
    }

    public function getByDriverId($driverId)
    {
        $this->instance = $this->model->where('driver_id', $driverId)
            ->with(['driver', 'user'])
            ->get();
        return $this->instance;
    }

    public function createAuthCurrent($data)
    {
        $this->instance = auth('sanctum')->user()->reviews()->create($data);
        return $this->instance;
    }
    public function store(array $data)
    {
        return $this->model->create($data);
    }
}

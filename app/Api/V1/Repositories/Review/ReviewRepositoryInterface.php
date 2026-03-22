<?php

namespace App\Api\V1\Repositories\Review;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ReviewRepositoryInterface extends EloquentRepositoryInterface
{

    public function getByDriverId($driverId);
    public function createAuthCurrent($data);
    public function store(array $data);
}

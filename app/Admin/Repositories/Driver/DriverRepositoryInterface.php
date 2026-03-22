<?php

namespace App\Admin\Repositories\Driver;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DriverRepositoryInterface extends EloquentRepositoryInterface
{
    public function getUser($userId);
    public function count();
    public function searchAllLimit($value = '', $meta = [], $limit = 10);

    public function findMany(array $ids);

    public function getOrderByDriver($id);

    public function getActiveVerifiedDrivers();

}

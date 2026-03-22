<?php

namespace App\Admin\Repositories\Address;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface AddressRepositoryInterface extends EloquentRepositoryInterface
{
    public function getUserById($userId);
    public function getDriverByUserId($userId);
}

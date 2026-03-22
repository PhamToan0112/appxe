<?php

namespace App\Api\V1\Repositories\Address;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface AddressRepositoryInterface extends EloquentRepositoryInterface
{

    public function getByUserId($userId);
    public function create(array $data);
    public function updateAddress(int $id, array $data);
}

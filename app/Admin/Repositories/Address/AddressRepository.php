<?php

namespace App\Admin\Repositories\Address;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Address;
use App\Models\User;
use App\Models\Driver;

class AddressRepository extends EloquentRepository implements AddressRepositoryInterface
{


    public function getModel(): string
    {
        return Address::class;
    }

    public function getUserById($userId)
    {
        return User::find($userId);
    }
    public function getDriverByUserId($userId)
    {
        $user = User::find($userId);

        return $user ? $user->driver : null;
    }
}

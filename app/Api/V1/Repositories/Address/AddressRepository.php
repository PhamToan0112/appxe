<?php

namespace App\Api\V1\Repositories\Address;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Address;

class AddressRepository extends EloquentRepository implements AddressRepositoryInterface
{
    public function getModel(): string
    {
        return Address::class;
    }

    public function getByUserId($userId)
    {
        return Address::where('user_id', $userId)->get();
        
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateAddress(int $id, array $data)
    {
        $address = $this->model->find($id);
        if ($address) {
            $address->update($data);
            return $address;
        }
        return false;
    }
}

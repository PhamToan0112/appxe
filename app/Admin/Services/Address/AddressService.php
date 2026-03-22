<?php

namespace App\Admin\Services\Address;

use App\Admin\Repositories\Address\AddressRepositoryInterface;
use App\Admin\Services\Address\AddressServiceInterface;
use App\Enums\Address\AddressType;
use Exception;
use Illuminate\Http\Request;

class AddressService implements AddressServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected AddressRepositoryInterface $repository;

    public function __construct(AddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object
    {

        $data = $request->validated();
        $data['latitude'] = $data['lat'];
        $data['longitude'] = $data['lng'];

        return $this->repository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {

        $data = $request->validated();

        return $this->repository->update($data['id'], $data);
    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }
}

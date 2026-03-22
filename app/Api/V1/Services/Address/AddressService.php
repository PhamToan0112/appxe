<?php

namespace App\Api\V1\Services\Address;

use App\Api\V1\Repositories\Address\AddressRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Exception;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
class AddressService implements AddressServiceInterface
{
    use AuthSupport, AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected AddressRepositoryInterface $repository;


    public function __construct(
        AddressRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $data = $request->validated();
        return $this->repository->getByUserId($data['user_id']);
    }

    public function delete($id): object|bool
    {
        $address = $this->repository->findOrFail($id);
        if ($address) {
            $address->delete($id);
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = $this->getCurrentUserId();
            $address = $this->repository->create($data);
            DB::commit();
            return $address;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create address: ' . $e->getMessage());
            throw new Exception('Address creation failed.');
        }
    }
    
    /**
     * @throws Exception
     */
    public function update(Request $request, $id): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id']= $this-> getCurrentUserId();
            $address = $this->repository->updateAddress($id, $data);
            DB::commit();
            return $address;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update address: ' . $e->getMessage());
            throw new Exception('Address update failed.');
        }
    }
}

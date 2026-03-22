<?php

namespace App\Api\V1\Support;

use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;


trait AuthServiceApi
{
    private static string $GUARD_API = 'api';

    private static string $GUARD_API_STORE = 'store-api';


    public function getCurrentUserId()
    {

        return auth(self::$GUARD_API)->user()->id;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        return auth(self::$GUARD_API)->user();
    }

    public function getCurrentStoreId()
    {
        return auth(self::$GUARD_API_STORE)->user()->id;
    }

    public function getCurrentStoreUser(): ?Authenticatable
    {
        return auth(self::$GUARD_API_STORE)->user();
    }

    private function getEntityByUserId($repositoryInterface)
    {
        $repository = app($repositoryInterface);
        $userId = $this->getCurrentUserId();
        return $repository->findByField('user_id', $userId);
    }

    /**
     * @throws Exception
     */
    public function getCurrentDriver()
    {
        return $this->getEntityByUserId(DriverRepositoryInterface::class);
    }

    /**
     * @throws Exception
     */
    public function getCurrentDriverId()
    {
        $driver = $this->getCurrentDriver();
        return $driver ? $driver->id : null;
    }
}
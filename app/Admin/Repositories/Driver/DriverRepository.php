<?php

namespace App\Admin\Repositories\Driver;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Enums\Driver\VerificationStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\User\UserStatus;
use App\Models\Driver;
use App\Models\User;
use App\Models\Order;

class DriverRepository extends EloquentRepository implements DriverRepositoryInterface
{
    public function getModel(): string
    {
        return Driver::class;
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getUser($userId)
    {
        return User::where('id', $userId)->first();
    }
    public function count()
    {
        return $this->model->count();
    }
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model;

        $this->getQueryBuilderFindByKey($keySearch);

        $this->applyFilters($meta);

        return $this->instance->driver()->limit($limit)->get();
    }
    protected function getQueryBuilderFindByKey($key): void
    {

        $this->instance = $this->instance->whereHas('user', function ($query) use ($key) {
            $query->where('phone', 'LIKE', "%$key%")
                ->orWhere('email', 'LIKE', "%$key%")
                ->orWhere('fullname', 'LIKE', "%$key%");
        });
    }

    public function findMany(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getOrderByDriver($id)
    {
        return Order::where('driver_id', $id);
    }

    public function getActiveVerifiedDrivers()
    {
        return $this->model->where('is_verified', VerificationStatus::Verified)
            ->whereHas('user', function ($query) {
                $query->where('status', UserStatus::Active);
            })->get();
    }
}
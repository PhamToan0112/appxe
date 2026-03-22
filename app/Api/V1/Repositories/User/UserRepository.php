<?php

namespace App\Api\V1\Repositories\User;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Traits\Roles;
use App\Enums\Order\OrderStatus;
use App\Enums\User\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    use Roles;

    protected $select = [];

    public function getModel(): string
    {
        return User::class;
    }

    public function getConfiguration($userId)
    {
        return $this->model->where('id', $userId)->first();
    }


    public function emailExists(string $email, int $userId): bool
    {
        return User::where('email', $email)
            ->where('id', '!=', $userId)
            ->exists();
    }

    public function getAllUsers(Request $request)
    {
        $data = $request->validated();
        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;
        $orderTypes = $data['order_type'] ?? [];

        return User::with(['orders.shipments'])
            ->whereHas('orders', function ($query) use ($orderTypes) {
                $query->whereNull('driver_id')
                    ->when($orderTypes, function ($query) use ($orderTypes) {
                        $query->whereIn('order_type', $orderTypes);
                    });
            })
            ->whereHas('roles', function ($query) {
                $query->where('name', $this->getRoleCustomer());
            })
            ->where('status', UserStatus::Active)
            ->paginate($limit, ['*'], 'page', $page);
    }


}

<?php

namespace App\Api\V1\Repositories\Discount;
use App\Admin\Repositories\Discount\DiscountRepository as AdminCategoryRepository;
use App\Admin\Repositories\EloquentRepository;
use App\Models\Discount;
use App\Models\DiscountApplication;
use Illuminate\Http\Request;

class DiscountRepository extends EloquentRepository implements DiscountRepositoryInterface
{
    public function getModel()
    {
        return Discount::class;
    }

    public function findByUserOrDriver(Request $request)
    {
        // TODO: Implement findByUserOrDriver() method.
    }

    public function checkDiscountApplied($filter): bool
    {
        $query = DiscountApplication::where('discount_code_id', $filter['discount_code_id']);

        if (isset($filter['user_id'])) {
            $query->where('user_id', $filter['user_id']);
        } elseif (isset($filter['driver_id'])) {
            $query->where('driver_id', $filter['driver_id']);
        }

        return $query->exists();
    }

    public function findByCode($code)
    {
        return Discount::where('code', $code)
            ->active()
            ->first();
    }

    public function getByDriverId($driverId)
    {
        return Discount::whereHas('drivers', function ($query) use ($driverId) {
            $query->where('driver_id', $driverId);
        })->active()->get();
    }
}
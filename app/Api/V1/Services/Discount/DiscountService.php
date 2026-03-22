<?php

namespace App\Api\V1\Services\Discount;


use App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Discount\DiscountSource;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use App\Traits\UseLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscountService implements DiscountServiceInterface
{
    use AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;


    protected DiscountApplicationRepositoryInterface $repository;
    protected DiscountRepositoryInterface $discountRepository;

    public function __construct(
        DiscountApplicationRepositoryInterface $repository,
        DiscountRepositoryInterface $discountRepository

    ) {
        $this->repository = $repository;
        $this->discountRepository = $discountRepository;
    }


    /**
     * @throws Exception
     */

    public function findByUserOrDriver(Request $request)
    {
        $data = $request->validated();
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;

        $userId = $this->getCurrentUserId();
        $driverId = $this->getCurrentDriverId();

        if ($driverId) {
            $entity = 'driver_id';
            $id = $driverId;
        } else {
            $entity = 'user_id';
            $id = $userId;
        }

        $filter = [$entity => $id];

        return $this->repository->findByActive($filter, $limit, $page);
    }
    /**
     * @throws Exception
     */

    public function getDiscountByUserOrDriver(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $code = $data['code'];

            $userId = $this->getCurrentUserId();
            $driverId = $this->getCurrentDriverId();

            $discount = $this->discountRepository->findByCode($code);

            if (!isset($discount) || !$discount->isActive()) {
                return false;
            }
            if ($driverId) {
                $entity = 'driver_id';
                $id = $driverId;
            } else {
                $entity = 'user_id';
                $id = $userId;
            }

            $filter = [
                $entity => $id,
                'discount_code_id' => $discount->id
            ];
            if ($this->discountRepository->checkDiscountApplied($filter)) {
                return response()->json(['error' => 'Mã giảm giá đã được sử dụng.'], 400);
            }
            $discountApplication = $this->repository->create($filter);
            DB::commit();
            return $discountApplication;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Discount create failed', $e);
            return false;
        }

    }

    public function getDiscountByDriver(Request $request)
    {
        $data = $request->validated();
        $driverId = $data['driver_id'];
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        return $this->repository->findByActive(['driver_id' => $driverId], $limit, $page);
    }


    public function checkDiscountByDriver(Request $request)
    {
        $data = $request->validated();
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        $driverId = $data['driver_id'];
        $filter = [
            'driver_id' => $driverId,
        ];
        return $this->repository->findByActive($filter, $limit, $page);
    }

    public function isEligible($discount, float $subTotal): bool
    {
        if (!$discount->isActive()) {
            return false;
        }
        if (isset($discount->min_order_amount) && $subTotal < $discount->min_order_amount) {

            return false;
        }
        return true;
    }

    public function driverStore(Request $request): object|bool
    {

        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['source'] = DiscountSource::Driver;
            $data['status'] = DiscountStatus::Draft;
            $data['code'] = uniqid_real(6);

            if ($data['type'] == DiscountType::Money->value) {
                $data['percent_value'] = null;
            } elseif ($data['type'] == DiscountType::Percent->value) {
                $data['discount_value'] = null;
            }

            $discount = $this->discountRepository->create($data);
            $discountId = $discount->id;

            $driverId = $this->getCurrentDriverId();

            if ($driverId)
                $this->discountRepository->attachRelations($discountId, [$driverId], 'drivers');
            DB::commit();

            return $discount;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Discount create failed', $e);
            return false;
        }
    }

    public function driverUpdate(Request $request): object|bool
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($data['type'] == DiscountType::Money->value) {
                $data['percent_value'] = null;
            } elseif ($data['type'] == DiscountType::Percent->value) {
                $data['discount_value'] = null;
            }
            $discountId = $data['id'];

            $discount = $this->discountRepository->update($discountId, $data);

            DB::commit();
            return $discount;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Discount update failed', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function driverDelete($id): object|bool
    {
        $discount = $this->discountRepository->findOrFail($id);
        if ($discount) {
            $discount->update(['status' => DiscountStatus::Inactive]);
        }

        return true;
    }

    public function getOptionDiscountCode(Request $request)
    {
        $data = $request->validated();

        $option = $data['option'] ?? null; // expired, active
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;
        $now = Carbon::now();

        $filter = [
            ['status', '=', DiscountStatus::Published]
        ];

        if ($option == 'active') {
            $filter[] = ['date_end', '>=', $now];
        } else if ($option == 'expired') {
            $filter[] = ['date_end', '<', $now];
        }

        return $this->discountRepository->getByQueryBuilder($filter)
            ->paginate($limit, ['*'], 'page', $page);
    }


}

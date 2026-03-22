<?php

namespace App\Api\V1\Services\Review;

use App\Admin\Repositories\Order\OrderRepository;
use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use Illuminate\Support\Facades\log;
class ReviewService implements ReviewServiceInterface
{
    use AuthSupport, AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ReviewRepositoryInterface $repository;
    protected OrderRepository $orderRepository;


    public function __construct(
        ReviewRepositoryInterface $repository,
        OrderRepository           $orderRepository
    ) {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {   
        $data = $request->validated();
        Log::info('array',[$data]);
        return $this->repository->getByDriverId($data['driver_id']);
    }   

    public function store(Request $request): bool|object
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->findOrFail($data['order_id']);
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $data['driver_id'] = $order->driver_id;
            $review = $this->repository->create($data);
            DB::commit();
            return $review;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

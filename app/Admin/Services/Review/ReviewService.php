<?php

namespace App\Admin\Services\Review;

use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Admin\Services\Review\ReviewServiceInterface;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReviewService implements ReviewServiceInterface
{
    use UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ReviewRepositoryInterface $repository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getReviews($id)
    {
        $reviews = $this->repository->getReviews($id)->get();
        if ($reviews->isEmpty()) {
            return 0;
        }

        $total = 0;

        foreach ($reviews as $review) {
            $total += $review->rating;
        }

        return [
            'driver' => $id,
            'avg' => round($total / $reviews->count(), 1),
        ];
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

}
<?php

namespace App\Api\V1\Http\Controllers\Review;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Review\ReviewRequest;
use App\Api\V1\Services\Review\ReviewServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use App\Api\V1\Http\Resources\Review\{ReviewResource, ShowReviewResource};
use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;

/**
 * @group Đánh giá
 */
class ReviewController extends Controller
{
    use Response, UseLog, AuthServiceApi;

    protected $service;
    protected $repository;

    public function __construct(
        ReviewServiceInterface    $service,
        ReviewRepositoryInterface $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Danh sách review của Tài xế
     *
     * Lấy danh sách review của Tài xế.
     *
     * Trạng thái đánh giá (status): gồm 3 trang thái
     * - active  :(mặc định khi tạo review) - Đã Phê duyệt
     * - pending : Đang chờ duyệt
     * - deleted : Đã xoá
     *
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *              "fullname": "Tran Van A",
     *              "avatar": "http://domain.com/public/assets/images/default-image.png",
     *              "content": "content",
     *              "rating": 5
     *          }
     *      ]
     * }
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(): JsonResponse
    {
        try {
            $reviews = $this->repository->getBy(['driver_id' => $this->getCurrentDriverId()]);
            return $this->jsonResponseSuccess(ShowReviewResource::collection($reviews));
        } catch (Exception $e) {
            $this->logError('Review fetching failed:', $e);
            return $this->jsonResponseError('Review fetching failed', 500);
        }
    }

    /**
     * Tạo đánh giá
     *
     * Tạo đánh giá cho Tài xế.
     *
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated
     * @bodyParam order_id integer required ID Đơn Hàng. Example: 1
     * @bodyParam rating integer required Xếp hạng đánh giá từ 1 - 5 sao. Example: 5
     * @bodyParam content string Nội dung đánh giá. Example: Content
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 10,
     *          "fullname": "Tran Van A",
     *          "avatar": "http://domain.com/public/assets/images/default-image.png",
     *          "content": "content",
     *          "rating": 5
     *      }
     * }
     *
     * @param ReviewRequest $request
     * @return JsonResponse
     */
    public function store(ReviewRequest $request): JsonResponse
    {
        try {
            $review = $this->service->store($request);
            return $this->jsonResponseSuccess(new ReviewResource($review));
        } catch (Exception $e) {
            $this->logError('Review creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }
}

<?php

namespace App\Api\V1\Http\Controllers\WeightRange;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Enums\DefaultStatus;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @group Trọng lượng
 */
class WeightRangeController extends Controller
{
    use Response, UseLog;


    public function __construct(

        WeightRangeRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
        $this->middleware('auth:api', ['except' => ['index']]);

    }

    /**
     * Danh sách Trọng lượng
     *
     * Lấy danh sách thể loại có trạng thái là Published
     *
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *              "name": "Thể loại 1",
     *              "description": "Nội dung 1",
     *              "status": "active"
     *          }
     *      ]
     * }
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $category = $this->repository->getBy(['status' => DefaultStatus::Published]);
            return $this->jsonResponseSuccess($category);
        } catch (Exception $e) {
            $this->logError('Category fetching failed:', $e);
            return $this->jsonResponseError('Category fetching failed', 500);
        }
    }

}

<?php

namespace App\Api\V1\Http\Controllers\Category;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Category\CategoryRequest;
use App\Api\V1\Http\Resources\Category\AllCategoryActiveResource;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use App\Api\V1\Repositories\Category\CategoryRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;

/**
 * @group Thể loại
 */
class CategoryController extends Controller
{
    use Response, UseLog, AuthServiceApi;

    protected $repository;

    public function __construct(
        CategoryRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách thể loại
     *
     * Lấy danh sách thể loại có trạng thái là active
     * 
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated
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
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $category = $this->repository->getCategoryActive();
            return $this->jsonResponseSuccess(AllCategoryActiveResource::collection($category));
        } catch (Exception $e) {
            $this->logError('Category fetching failed:', $e);
            return $this->jsonResponseError('Category fetching failed', 500);
        }
    }

}

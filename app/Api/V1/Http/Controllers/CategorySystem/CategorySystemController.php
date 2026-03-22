<?php

namespace App\Api\V1\Http\Controllers\CategorySystem;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\CategorySystem\CategorySystemRequest;
use App\Api\V1\Http\Resources\CategorySystem\{AllCategorySystemResource};
use App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Api\V1\Services\CategorySystem\CategorySystemServiceInterface;
use App\Api\V1\Support\Response;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Danh mục hệ thống
 */
class CategorySystemController extends Controller
{
    use Response;

    public function __construct(
        CategorySystemRepositoryInterface $repository,
        CategorySystemServiceInterface    $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * DS Danh mục hệ thống
     *
     * Lấy danh sách Danh mục hệ thống.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam page integer
     * Trang hiện tại, page > 0. Ví dụ: 1
     *
     * @queryParam limit integer
     * Số lượng Phòng trong 1 trang, limit > 0. Ví dụ: 1
     *
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "name": "Thông tin của Tên Phòng",
     *
     *         }
     *      ]
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Vui lòng kiểm tra lại các trường field"
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param CategorySystemRequest $request
     *
     * @return JsonResponse
     */
    public function index(CategorySystemRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $category_system = $this->repository->paginate(...$data);
            $category_system = new AllCategorySystemResource($category_system);
            return $this->jsonResponseSuccess($category_system);
        } catch (Exception $e) {
            return $this->jsonResponseError("Failed get category system", 500);
        }
    }
}

;

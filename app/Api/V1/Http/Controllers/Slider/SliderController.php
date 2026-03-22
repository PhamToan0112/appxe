<?php

namespace App\Api\V1\Http\Controllers\Slider;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Slider\SliderRepositoryInterface;
use App\Api\V1\Http\Resources\Slider\SliderResource;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Enums\Slider\SliderStatus;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Slider
 */
class SliderController extends Controller
{
    use UseLog, Response;

    public function __construct(
        SliderRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách slider
     *
     * Lấy danh sách slider.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": [
     *         {
     *             "name": "Banner khách hàng",
     *             "desc": null,
     *             "items": []
     *         },
     *         {
     *             "name": "Banner Trang chủ",
     *             "desc": "Banner Trang chủ",
     *             "items": [
     *                 {
     *                     "title": "Banner 1",
     *                     "link": "#",
     *                     "image": "http://localhost:8888/2792-SEE/public/uploads/images/banner/99-thuyen_hoa.jpg",
     *                     "mobile_image": "http://localhost:8888/2792-SEE/public/uploads/images/banner/99-thuyen_hoa.jpg"
     *                 },
     *                 {
     *                     "title": "Banner 2",
     *                     "link": "#",
     *                     "image": "http://localhost:8888/2792-SEE/public/uploads/images/banner/99-thuyen_hoa.jpg",
     *                     "mobile_image": "http://localhost:8888/2792-SEE/public/uploads/images/banner/99-thuyen_hoa.jpg"
     *                 }
     *             ]
     *         }
     *     ]
     * }
     *
     * @return JsonResponse
     */


    public function index(): JsonResponse
    {
        try {
            $response = $this->repository->getBy(['status' => SliderStatus::Active]);
            $response = SliderResource::collection($response);

            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError("Slider list error", $e);
            return $this->jsonResponseError("Slider list error", 500);
        }
    }

    /**
     * Chi tiết slider
     *
     * Lấy chi tiết slider.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *           "name": "Home page",
     *           "desc": "321",
     *           "items": [
     *               {
     *                   "title": "slider 1",
     *                   "link": "#",
     *                   "image": "http://localhost/topzone/public/uploads/files/img-catesound.png",
     *                   "mobile_image": "http://localhost/topzone/public/uploads/files/airpods-2268.jpeg"
     *               },
     *               {
     *                   "title": "slider 2",
     *                   "link": "#",
     *                   "image": "http://localhost/topzone/public/uploads/files/mac.png",
     *                   "mobile_image": "http://localhost/topzone/public/uploads/files/mac.png"
     *               }
     *           ]
     *       }
     * }
     *
     * @param $key
     * @return JsonResponse
     */
    public function show($key): JsonResponse
    {
        try {

            $slider = $this->repository->findByPlainKeyWithRelations($key);
            $slider = new SliderResource($slider);
            return $this->jsonResponseSuccess($slider);
        } catch (Exception $e) {
            $this->logError("Slider details error", $e);
            return $this->jsonResponseError("Slider details error", 500);
        }

    }
}
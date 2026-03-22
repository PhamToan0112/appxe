<?php

namespace App\Api\V1\Http\Controllers\Route;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Http\Requests\Route\RouteRequest;
use App\Api\V1\Http\Resources\Route\RouteResource;
use App\Api\V1\Repositories\Route\RouteRepositoryInterface;
use App\Api\V1\Services\Route\RouteServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Danh sách chuyến đi C-Intercity
 */
class RouteController extends Controller
{
    use Response, UseLog;


    public function __construct(
        RouteServiceInterface    $service,

        RouteRepositoryInterface $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;

    }

    /**
     * Tạo một chuyến đi mới cho tài xế.
     * API này cho phép tạo một chuyến đi dựa trên các thông tin được cung cấp bởi người dùng qua phương thức POST.
     * Phương thức này yêu cầu xác thực và quyền hạn thích hợp.
     *
     * @authenticated
     *
     * @bodyParam start_address string required Địa chỉ bắt đầu của chuyến đi. Địa chỉ phải là một chuỗi ký tự. Example: Sài Gòn, Việt Nam.
     * @bodyParam end_address string required Địa chỉ kết thúc của chuyến đi. Địa chỉ phải là một chuỗi ký tự. Example: Bảo Lộc, Lâm Đồng, Việt Nam.
     * @bodyParam price int required Giá của chuyến đi. Giá trị phải là một số. Example: 200000.
     * @bodyParam return_price int nullable Giá trị trả về cho chuyến đi. Giá trị này không bắt buộc và phải là một số. Example: 150000.
     * @bodyParam departure_time string required Thời gian khởi hành cho chuyến đi. Example: 07:30:00
     *
     * @response 201 {
     *     "status": 201,
     *     "message": "Tạo chuyến đi thành công.",
     *     "data": {
     *         "id": 1,
     *         "driver_id": 1,
     *         "start_address": "Sài Gòn, Việt Nam",
     *         "start_lat": 10.823099,
     *         "start_lng": 106.629664,
     *         "end_address": "Bảo Lộc, Lâm Đồng, Việt Nam",
     *         "end_lat": 11.573105,
     *         "end_lng": 107.834692,
     *         "price": 200000,
     *         "return_price": 150000,
     *         "departure_time": "2024-12-31T07:30:00",
     *         "created_at": "2024-10-15T08:34:43.000000Z",
     *         "updated_at": "2024-10-15T08:34:43.000000Z"
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Không thể tạo chuyến đi do lỗi hệ thống."
     * }
     */


    public function store(RouteRequest $request): JsonResponse
    {
        try {
            $route = $this->service->create($request);
            return $this->jsonResponseSuccess(new RouteResource($route), 'Route created successfully');
        } catch (BadRequestException $e) {
            return $this->jsonResponseError($e->getMessage());
        } catch (Exception $e) {
            $this->logError("Create route failed", $e);
            return $this->jsonResponseError('Failed to create route', 500);
        }
    }

    /**
     * Tìm kiếm chuyến đi CIntercity
     * API này cho phép tìm kiếm các chuyến đi giữa các thành phố dựa trên địa chỉ bắt đầu và kết thúc.
     * Phương thức này yêu cầu xác thực.
     *
     * `type`:
     *  - one_way: 1 chiều
     *  - round_trip: 2 chiều
     *
     * @authenticated
     *
     * @queryParam start_address string required Địa chỉ bắt đầu của chuyến đi. Đây là một chuỗi ký tự. Example: Sài Gòn, Việt Nam.
     * @queryParam end_address string required Địa chỉ kết thúc của chuyến đi. Đây là một chuỗi ký tự. Example: Bảo Lộc, Lâm Đồng, Việt Nam.
     * @queryParam type string required Loại chuyến đi. Đây phải là một trong các giá trị được định nghĩa trong enum TripType. Example: one_way
 *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 1,
     *              "driver_id": 1,
     *              "start_address": "Sài Gòn, Việt Nam",
     *              "start_lat": 10.823099,
     *              "start_lng": 106.629664,
     *              "end_address": "Bảo Lộc, Lâm Đồng, Việt Nam",
     *              "end_lat": 11.573105,
     *              "end_lng": 107.834692,
     *              "price": 200000,
     *          }
     *      ]
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy tài xế."
     * }
     *
     * @param RouteRequest $request Yêu cầu chứa các tham số để thực hiện tìm kiếm.
     * @return JsonResponse Trả về dữ liệu chuyến đi nếu tìm thấy hoặc thông báo lỗi nếu không tìm thấy.
     */


    public function search(RouteRequest $request): JsonResponse
    {
        try {
            $response = $this->service->search($request);
            return $this->jsonResponseSuccess(RouteResource::collection($response));
        } catch (Exception $e) {
            $this->logError("Search route failed", $e);
            return $this->jsonResponseError('Search route failed', 500);
        }
    }

}

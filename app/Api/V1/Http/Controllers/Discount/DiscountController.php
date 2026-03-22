<?php

namespace App\Api\V1\Http\Controllers\Discount;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Discount\CheckDiscountRequest;
use App\Api\V1\Http\Requests\Discount\DiscountDriverRequest;
use App\Api\V1\Http\Requests\Discount\DiscountOptionRequest;
use App\Api\V1\Http\Requests\Discount\DiscountRequest;
use App\Api\V1\Http\Requests\Discount\DiscountStoreRequest;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Services\Discount\DiscountServiceInterface;
use App\Api\V1\Http\Resources\Discount\{DiscountResource, DiscountResourceCollection, DiscountApplicationResource};
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Validate\Validator;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Mã Giảm Giá
 */
class DiscountController extends Controller
{
    use Response, UseLog, AuthServiceApi;


    public function __construct(
        DiscountServiceInterface $service,
        DiscountRepositoryInterface $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }


    /**
     * Chi tiết Mã Giảm Giá
     *
     * API này dùng để lấy chi tiết của một mã giảm giá cụ thể.
     *
     * @authenticated
     *
     * @urlParam id int required ID của mã giảm giá cần lấy chi tiết. Example: 1
     *
     * @response {
     *     "status": 200,
     *     "data": {
     *         "id": 1,
     *         "code": "DISCOUNT2023",
     *         "date_start": "2023-01-01T00:00:00.000000Z",
     *         "date_end": "2023-12-31T23:59:59.000000Z",
     *         "max_usage": 100,
     *         "min_order_amount": 50000,
     *         "type": "Percent",
     *         "discount_value": 10,
     *         "source": "Admin",
     *         "status": "Published"
     *     },
     *     "message": "Lấy chi tiết mã giảm giá thành công."
     * }
     *
     * @response status=404 {
     *     "status": 404,
     *     "message": "Không tìm thấy mã giảm giá."
     * }
     *
     * @response status=500 {
     *     "status": 500,
     *     "message": "Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá."
     * }
     *
     * @param int $id ID của mã giảm giá.
     * @return JsonResponse Trả về đối tượng JsonResponse chứa thông tin chi tiết về mã giảm giá hoặc thông báo lỗi.
     * @throws Exception Bắt các ngoại lệ có thể xảy ra trong quá trình xử lý.
     */
    public function show(int $id): JsonResponse
    {
        try {
            Validator::validateExists($this->repository, $id);
            $discount = $this->repository->findOrFail($id);
            $discount = new DiscountResource($discount);
            return $this->jsonResponseSuccess($discount);
        } catch (Exception $e) {
            return $this->jsonResponseError('Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá.');
        }
    }
    /**
     * Thêm tài khoản vào mã giảm giá
     *
     * API này dùng để thêm tài khoản hiện tại vào mã giảm giá đó (Nếu là tài xế thì thêm driver_id,ngược lại là user_id).
     * Nếu token thuộc về người dùng, API sẽ thêm mã giảm giá cho người dùng đó.
     * Nếu token thuộc về tài xế, API sẽ thêm mã giảm giá cho tài xế đó.
     *
     * @authenticated
     *
     * @bodyParam code string required Mã giảm giá. Example: UUUUUU
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 10,
     *          "code": "UUUUUU",
     *          "discount_value": 2000
     *      }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Mã giảm giá đã được sử dụng."
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy mã giảm giá hoặc hết hạn."
     * }
     *
     * @param DiscountRequest $request
     * @return JsonResponse
     */
    public function createDiscountCode(DiscountRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getDiscountByUserOrDriver($request);
            if ($response instanceof JsonResponse && $response->getStatusCode() === 400) {
                return $response;
            }
            return $this->jsonResponseSuccess(new DiscountResource($response));
        } catch (Exception $e) {
            $this->logError("Get discounts failed", $e);
            return $this->jsonResponseError('Không tìm thấy mã giảm giá hoặc hết hạn', 404);
        }
    }

    /**
     * Lấy Mã Giảm Giá Theo Người Dùng hoặc Tài Xế hiện tại
     *
     * API này trả về mã giảm giá dựa trên token người dùng hoặc tài xế.
     * Nếu token thuộc về người dùng, API sẽ trả về mã giảm giá cho người dùng đó.
     * Nếu token thuộc về tài xế, API sẽ trả về mã giảm giá cho tài xế đó.
     *
     * @authenticated
     * @queryParam page int optional. Example: 1
     * @queryParam limit int optional. Example: 10
     *
     * @response {
     *     "status": 200,
     *     "data": {
     *         "id": 1,
     *         "code": "BA4AB9",
     *         "discount_value": 10,
     *     },
     *     "message": "Lấy mã giảm giá thành công."
     * }
     *
     * @response status=404 {
     *     "status": 404,
     *     "message": "Không tìm thấy mã giảm giá."
     * }
     *
     * @response status=500 {
     *     "status": 500,
     *     "message": "Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá."
     * }
     *
     * @param DiscountRequest $request
     * @return JsonResponse Trả về đối tượng JsonResponse chứa thông tin mã giảm giá.
     */
    public function getByUserOrDriver(DiscountRequest $request): JsonResponse
    {
        try {
            $response = $this->service->findByUserOrDriver($request);
            return $this->jsonResponseSuccess(new DiscountResourceCollection($response));

        } catch (Exception $e) {
            $this->logError("Get discounts failed", $e);
            return $this->jsonResponseError('Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá.', 500);
        }

    }

    /**
     * Lấy Mã Giảm Giá Theo  Tài Xế
     *
     * API này trả về mã giảm giá dựa trên  tài xế.
     *
     * @authenticated
     * @queryParam page int optional. Example: 1
     * @queryParam limit int optional. Example: 10
     *
     * @response {
     *     "status": 200,
     *     "data": {
     *         "id": 1,
     *         "code": "BA4AB9",
     *         "discount_value": 10,
     *     },
     *     "message": "Lấy mã giảm giá thành công."
     * }
     *
     * @response status=404 {
     *     "status": 404,
     *     "message": "Không tìm thấy mã giảm giá."
     * }
     *
     * @response status=500 {
     *     "status": 500,
     *     "message": "Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá."
     * }
     *
     * @param DiscountDriverRequest $request
     * @return JsonResponse Trả về đối tượng JsonResponse chứa thông tin mã giảm giá.
     */
    public function getByDriver(DiscountDriverRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getDiscountByDriver($request);
            return $this->jsonResponseSuccess(new DiscountResourceCollection($response));

        } catch (Exception $e) {
            $this->logError("Get discounts failed", $e);
            return $this->jsonResponseError('Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá.', 500);
        }

    }


    /**
     * Kiểm Tra Mã Giảm Giá Cho Tài Xế
     *
     * API này dùng để kiểm tra các mã giảm giá có thể áp dụng cho tài xế dựa trên `driver_id` và `sub_total` được cung cấp.
     * API sẽ trả về danh sách các mã giảm giá cùng với trạng thái kiểm tra xem chúng có đủ điều kiện áp dụng không.
     *
     * Kiểm tra mã giảm giá(check):
     * - true: Đủ điều kiện
     * - false: Không đủ điều kiện
     *
     * @authenticated
     *
     * @queryParam sub_total float required Tổng giá trị đơn hàng cần kiểm tra. Example: 50000
     * @queryParam driver_id int required ID của tài xế. Example: 123
     * @queryParam page int optional Số trang muốn truy cập. Example: 1
     * @queryParam limit int optional Số lượng bản ghi trên một trang. Example: 10
     *
     * @response {
     *     "status": 200,
     *     "data": {
     *         "discounts": [
     *             {
     *                 "id": 2,
     *                 "discount": {
     *                     "id": 1,
     *                     "code": "UUUUUU",
     *                     "date_start": "10-08-2024 09:05",
     *                     "date_end": "07-09-2024 09:05",
     *                     "max_usage": 20000,
     *                     "min_order_amount": 20000,
     *                     "type": "Percent",
     *                     "discount_value": 2000,
     *                     "source": "ADMIN",
     *                     "status": "Published"
     *                 },
     *                 "check": false
     *             }
     *         ]
     *     },
     *     "message": "Lấy danh sách mã giảm giá thành công."
     * }
     *
     * @response status=404 {
     *     "status": 404,
     *     "message": "Không tìm thấy mã giảm giá hợp lệ cho tài xế."
     * }
     *
     * @response status=500 {
     *     "status": 500,
     *     "message": "Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá."
     * }
     *
     * @param CheckDiscountRequest $request
     * @return JsonResponse Trả về đối tượng JsonResponse chứa danh sách mã giảm giá hợp lệ cho tài xế.
     */
    public function checkDiscountByDriver(CheckDiscountRequest $request): JsonResponse
    {
        try {
            $response = $this->service->checkDiscountByDriver($request);
            return $this->jsonResponseSuccess(new DiscountResourceCollection($response));
        } catch (Exception $e) {
            $this->logError("Check discount failed", $e);
            return $this->jsonResponseError('Check discount for driver failed', 500);
        }
    }

    /**
     * Tài xế thêm mã giảm giá
     *
     * Tài xế thêm mã giảm giá
     *
     * Trạng thái mã giảm giá (status):
     * - 1: Đã xuất bản
     * - 2: Bản nháp
     * - 3: Không hoạt động
     *
     * Loại mã giảm giá (type):
     * - 1: Giảm giá theo tiền mặt
     * - 2: Giảm giá theo phần trăm
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     *@bodyParam date_start datetime required Ngày giờ bắt đầu áp dụng mã giảm giá. Example: 2024-09-11 09:05:00
     *@bodyParam date_end datetime required Ngày giờ kết thúc áp dụng mã giảm giá. Example: 2024-09-12 10:00:00
     *@bodyParam max_usage int nullable Số lần sử dụng tối đa của mã giảm giá. Example: 100
     *@bodyParam min_order_amount double nullable Giá trị đơn hàng tối thiểu để áp dụng mã giảm giá. Example: 50000
     *@bodyParam type tinyint required Loại mã giảm giá. Example: 1
     *@bodyParam discount_value double nullable Giá trị giảm giá (tiền mặt). Example: 10000
     *@bodyParam percent_value double nullable Giá trị giảm giá (%). Example: 10
     *@bodyParam status tinyint nullable Trạng thái mã giảm giá. Example: 1
     *@bodyParam description string required Mô tả mã giảm giá. Example: Mã giảm giá 10%
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */

    public function driverStore(DiscountStoreRequest $request): JsonResponse
    {
        try {
            $this->service->driverStore($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Create discount failed:', $e);
            return $this->jsonResponseError('Create discount failed', 500);
        }
    }

    /**
     * Tài xế cập nhật mã giảm giá
     *
     * Tài xế cập nhật mã giảm giá
     *
     * Trạng thái mã giảm giá (status):
     * - 1: Đã xuất bản
     * - 2: Bản nháp
     * - 3: Không hoạt động
     *
     * Loại mã giảm giá (type):
     * - 1: Giảm giá theo tiền mặt
     * - 2: Giảm giá theo phần trăm
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     *@bodyParam id int required ID của mã giảm giá. Example: 1
     *@bodyParam date_start datetime required Ngày giờ bắt đầu áp dụng mã giảm giá. Example: 2024-09-11 09:05:00
     *@bodyParam date_end datetime required Ngày giờ kết thúc áp dụng mã giảm giá. Example: 2024-09-12 10:00:00
     *@bodyParam max_usage int required Số lần sử dụng tối đa của mã giảm giá. Example: 100
     *@bodyParam min_order_amount double required Giá trị đơn hàng tối thiểu để áp dụng mã giảm giá. Example: 50000
     *@bodyParam type tinyint required Loại mã giảm giá. Example: 1
     *@bodyParam discount_value double nullable Giá trị giảm giá (tiền mặt). Example: 10000
     *@bodyParam percent_value double nullable Giá trị giảm giá (%). Example: 10
     *@bodyParam status tinyint required Trạng thái mã giảm giá. Example: 1
     *@bodyParam description string required Mô tả mã giảm giá. Example: Mã giảm giá 10%
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */

    public function driverUpdate(DiscountStoreRequest $request): JsonResponse
    {
        try {
            $this->service->driverUpdate($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Update discount failed:', $e);
            return $this->jsonResponseError('Update discount failed', 500);
        }
    }

    /**
     * Tài xế xóa mã giảm giá
     *
     * Tài xế xóa mã giảm giá
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id int required ID của mã giảm giá. Example: 1
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công."
     * }
     *
     * @response 500 {
     *   "status": 500,
     *   "message": "Error."
     * }
     *
     * @return JsonResponse
     */

    public function driverDelete($id): JsonResponse
    {
        try {
            $this->service->driverDelete($id);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Delete discount failed:', $e);
            return $this->jsonResponseError('Delete discount failed', 500);
        }
    }

    /**
     * Lấy Mã Giảm Giá Theo Option
     *
     * API này trả về mã giảm giá dựa trên option.
     * Option có thể là:
     * - `active`: Mã giảm giá còn hạn.
     * - `expired`: Mã giảm giá hết hạn.
     * - `null`: Tất cả mã giảm giá.
     *
     * @authenticated
     *
     * @queryParam option string optional Option để lấy mã giảm giá. Example: active
     * @queryParam page int optional Số trang muốn truy cập. Example: 1
     * @queryParam limit int optional Số lượng bản ghi trên một trang. Example: 10
     *
     * @response {
     *     "status": 200,
     *     "data": {
     *         "id": 1,
     *         "code": "BA4AB9",
     *         "type": "1",
     *         "discount_value": 10,
     *         "percent_value":null,
     *         "date_start": "16-09-2024 11:02",
     *         "date_end": "18-09-2024 11:02"
     *     },
     *     "message": "Lấy mã giảm giá thành công."
     * }
     *
     * @return JsonResponse Trả về đối tượng JsonResponse chứa thông tin mã giảm giá.
     */

    public function getOptionDiscountCode(DiscountOptionRequest $request): JsonResponse
    {
        try {
            $data = $this->service->getOptionDiscountCode($request);

            $response = DiscountResource::collection($data);

            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError("Get discounts failed", $e);
            return $this->jsonResponseError('Có lỗi xảy ra trong quá trình lấy thông tin mã giảm giá.', 500);
        }
    }
}

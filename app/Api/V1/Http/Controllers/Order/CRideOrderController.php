<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Http\Requests\Order\CRideCar\BookOrderRequest;
use App\Api\V1\Http\Requests\Order\CRideCar\DriverSelectOrderRequest;
use App\Api\V1\Http\Resources\Order\CRideCar\OrderCRideCarResource;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Order\CRideCar\OrderCRideCarServiceInterface;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Api\V1\Validate\Validator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


/**
 * @group Đơn hàng C-Ride/Car
 */
class CRideOrderController extends Controller
{
    use  Response, UseLog;

    protected UserRepositoryInterface $userRepository;

    protected OrderCRideCarServiceInterface $orderCRideCarService;

    public function __construct(
        OrderRepositoryInterface      $repository,
        UserRepositoryInterface       $userRepository,
        OrderServiceInterface         $service,
        OrderCRideCarServiceInterface $orderCRideCarService
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->orderCRideCarService = $orderCRideCarService;
        $this->middleware('auth:api');
    }


    /**
     * Tạo đơn hàng đặt xe (C-RIDE/CAR)
     *
     * API này dùng để tạo đơn hàng đặt xe dựa trên thông tin cung cấp bởi người dùng.
     *
     * Phuương thức thanh toán (status) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * Loại đơn hàng (type) gồm:
     * - C_RIDE: Đơn hàng đặt xe (Ride)
     * - C_CAR: Đơn hàng đặt xe (Car)
     * - C_INTERCITY: Đơn hàng liên tỉnh
     * - C_DELIVERY: Đơn hàng giao hàng
     *
     * Trạng thái đơn hàng (status) gồm:
     * - pending_driver_confirmation: Chờ tài xế xác nhận
     * - pending_customer_confirmation: Chờ khách hàng xác nhận
     * - driver_confirmed: Tài xế đã xác nhận
     * - customer_confirmed: Khách hàng đã xác nhận
     * - driver_declined: Tài xế đã từ chối đơn hàng
     * - customer_declined: Khách hàng đã từ chối đơn hàng
     * - in_transit: Đơn hàng đang trong quá trình di chuyển
     * - completed: Đơn hàng đã hoàn thành
     * - cancelled: Đơn hàng đã bị hủy
     * - failed: Đơn hàng không thành công
     * - returned: Đã trả hàng
     *
     * @authenticated
     *
     * @bodyParam start_latitude float required Vĩ độ của điểm bắt đầu. Example: 10.762622
     * @bodyParam start_longitude float required Kinh độ của điểm bắt đầu. Example: 106.660172
     * @bodyParam start_address string required Địa chỉ của điểm bắt đầu. Example: 268 Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh
     * @bodyParam end_latitude float required Vĩ độ của điểm kết thúc. Example: 10.823099
     * @bodyParam end_longitude float required Kinh độ của điểm kết thúc. Example: 106.629664
     * @bodyParam end_address string required Địa chỉ của điểm kết thúc. Example: 2 Phạm Ngọc Thạch, Phường Bến Nghé, Quận 1, Hồ Chí Minh
     * @bodyParam distance float optional Khoảng cách của chuyến đi. Example: 8.5
     * @bodyParam order_type string required Loại đơn hàng. Example: C_RIDE
     * @bodyParam desired_price float optional Giá mong muốn. Example: 2000
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tạo đơn hàng."
     * }
     *
     * @param BookOrderRequest $request
     * @return JsonResponse
     */
    public function createBookCarOrder(BookOrderRequest $request): JsonResponse
    {
        try {
        $response = $this->orderCRideCarService->createBookOrder($request);
            return $this->jsonResponseSuccess(new OrderCRideCarResource($response));
        } catch (Exception $e) {
            $this->logError('Order C_Ride/Car creation failed:', $e);
            return $this->jsonResponseError('Order C_Ride/Car creation failed', 500);
        }
    }

    /**
     * Cập nhật đơn hàng (Update order).
     *
     * API này được sử dụng để cập nhật thông tin đơn hàng.
     *
     * @authenticated
     *
     * @bodyParam id int required ID của đơn hàng cần cập nhật. Example: 123
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam total float optional Tổng tiền của đơn hàng. Example: 200000
     * @bodyParam sub_total float optional Tổng tiền phụ của đơn hàng. Example: 180000
     * @bodyParam platform_fee float optional Phí nền tảng. Example: 10000
     * @bodyParam discount_amount float optional Số tiền giảm giá (nếu có). Example: 5000
     * @bodyParam distance float optional Khoảng cách chuyến đi. Example: 10.5
     * @bodyParam discount_id string optional Mã giảm giá. Example: DISCOUNT2024
     * @bodyParam high_point_area_fee float optional Phí vùng cao điểm. Example: 3000
     * @bodyParam holiday_fee float optional Phí ngày lễ. Example: 2000
     * @bodyParam night_time_fee float optional Phí giờ đêm. Example: 2500
     * @bodyParam desired_price float optional Giá mong muốn. Example: 180000
     *
     * @response 200 {
     *     "status": "success",
     *     "message": "Order updated successfully.",
     *     "data": { }
     * }
     *
     * @response 400 {
     *     "status": "error",
     *     "message": "Invalid input or order not found."
     * }
     *
     * @response 500 {
     *     "status": "error",
     *     "message": "Internal server error."
     * }
     *
     * @param BookOrderRequest $request
     * @return JsonResponse
     */
    public function update(BookOrderRequest $request): JsonResponse
    {
        try {
            $response = $this->orderCRideCarService->update($request);
            return $this->jsonResponseSuccess(new OrderCRideCarResource($response));
        } catch (Exception $e) {
            $this->logError('Order C_Ride/Car update failed:', $e);
            return $this->jsonResponseError('Order C_Ride/Car update failed', 500);
        }
    }


    /**
     * Tài xế chọn đơn hàng
     *
     * API này cho phép tài xế chọn một đơn hàng chờ xác nhận (pending_driver_confirmation).
     *
     * @authenticated
     *
     * @bodyParam order_id int required ID của đơn hàng. Example: 123
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Tài xế đã chọn đơn hàng thành công.",
     *     "data": {
     *         "order_id": 123,
     *         "driver_id": 5,
     *         "status": "driver_confirmed"
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Đơn hàng không tồn tại hoặc không thể chọn."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể chọn đơn hàng."
     * }
     *
     * @param DriverSelectOrderRequest $request
     * @return JsonResponse
     */
    public function driverSelectOrder(DriverSelectOrderRequest $request): JsonResponse
    {
        try {
            $response = $this->orderCRideCarService->driverSelectOrder($request);
            return $this->jsonResponseSuccess(new OrderCRideCarResource($response));
        } catch (BadRequestException $e) {
            $this->logError('Driver found:', $e);
            return $this->jsonResponseError($e->getMessage(), 400);
        }catch (Exception $e) {
            $this->logError('Order C_Ride/Car creation failed:', $e);
            return $this->jsonResponseError('Order C_Ride/Car creation failed', 500);
        }
    }


    /**
     * Lấy chi tiết đơn hàng (C-RIDE/CAR)
     *
     * API này dùng để lấy chi tiết đơn hàng dựa trên ID của đơn hàng.
     *
     * Phuương thức thanh toán (status) gồm:
     *  - 1: online (Wallet)
     *  - 2: trực tiếp (tiền mặt)
     *
     *  Loại đơn hàng (type) gồm:
     *  - C_RIDE: Đơn hàng đặt xe (Ride)
     *  - C_CAR: Đơn hàng đặt xe (Car)
     *  - C_INTERCITY: Đơn hàng liên tỉnh
     *  - C_DELIVERY: Đơn hàng giao hàng
     *
     *  Trạng thái đơn hàng (status) gồm:
     *  - pending_driver_confirmation: Chờ tài xế xác nhận
     *  - pending_customer_confirmation: Chờ khách hàng xác nhận
     *  - driver_confirmed: Tài xế đã xác nhận
     *  - customer_confirmed: Khách hàng đã xác nhận
     *  - driver_declined: Tài xế đã từ chối đơn hàng
     *  - customer_declined: Khách hàng đã từ chối đơn hàng
     *  - in_transit: Đơn hàng đang trong quá trình di chuyển
     *  - completed: Đơn hàng đã hoàn thành
     *  - cancelled: Đơn hàng đã bị hủy
     *  - failed: Đơn hàng không thành công
     *  - returned: Đã trả hàng
     *
     * @authenticated
     *
     * @pathParam id int required ID của đơn hàng. Example: 20
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "id": 1,
     *         "start_latitude": 10.762622,
     *         "start_longitude": 106.660172,
     *         "start_address": "268 Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh",
     *         "end_latitude": 10.823099,
     *         "end_longitude": 106.629664,
     *         "end_address": "2 Phạm Ngọc Thạch, Phường Bến Nghé, Quận 1, Hồ Chí Minh",
     *         "payment_method": "1",
     *         "total": 200000,
     *         "distance": 8.5,
     *         "driver_id": 5,
     *         "order_type": "C_RIDE",
     *         "status": "InProgress"
     *     }
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Đơn hàng không tìm thấy."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể lấy thông tin đơn hàng."
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            Validator::validateExists($this->repository, $id);
            $response = $this->repository->findOrFail($id);
            return $this->jsonResponseSuccess(new OrderCRideCarResource($response));
        } catch (Exception $e) {
            return $this->jsonResponseError('Get detail order C-Ride-Car error');
        }
    }


}

<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\CIntercity\CIntercityRequest;
use App\Api\V1\Http\Resources\Order\CIntercity\OrderCIntercityResource;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Services\Order\CIntercity\OrderCInterCityServiceInterface;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Validate\Validator;


/**
 * @group Đơn hàng C-Intercity
 */
class CIntercityOrderController extends Controller
{
    use Response, UseLog;


    protected OrderCInterCityServiceInterface $orderCInterCityService;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface $service,
        OrderCInterCityServiceInterface $orderCInterCityService
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->orderCInterCityService = $orderCInterCityService;
        $this->middleware('auth:api');
    }


    /**
     * Tạo đơn hàng đặt xe liên tỉnh (C-Intercity)
     *
     * API này dùng để tạo đơn hàng đặt xe liên tỉnh dựa trên thông tin cung cấp bởi người dùng.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * Loại chuyến đi (trip_type) gồm:
     * - one_way: Chuyến đi một chiều
     * - round_trip: Chuyến đi khứ hồi
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
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam total float required Tổng tiền của đơn hàng. Example: 200000
     * @bodyParam sub_total float required Tổng tiền phụ của đơn hàng. Example: 180000
     * @bodyParam platform_fee float required Phí nền tảng được tính trên mỗi đơn hàng. Example: 10000
     * @bodyParam discount_amount float optional Số tiền giảm giá. Example: 2000
     * @bodyParam distance float optional Khoảng cách của chuyến đi. Example: 8.5
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam discount_id string optional Mã giảm giá nếu có. Example: DISCOUNT2024
     * @bodyParam note string optional Ghi chú cho đơn hàng. Example: Vui lòng đến đúng giờ
     * @bodyParam trip_type string required Loại chuyến đi: one_way hoặc round_trip. Example: one_way
     * @bodyParam departure_time datetime required Thời gian khởi hành theo định dạng Y-m-d H:i:s. Example: 2024-09-30 08:30:00
     * @bodyParam return_time datetime optional Thời gian quay về (nếu chuyến đi khứ hồi) theo định dạng Y-m-d H:i:s. Example: 2024-09-30 16:30:00
     * @bodyParam passenger_count int required Số lượng khách đi. Example: 4
     * @bodyParam reference_price float optional Giá tham khảo cho chuyến đi. Example: 250000
     * @bodyParam high_point_area_fee float optional Phí vùng cao điểm. Example: 5000
     * @bodyParam holiday_fee float optional Phí ngày lễ, áp dụng khi đơn hàng được đặt vào ngày lễ. Example: 3000
     * @bodyParam night_time_fee float optional Phí giờ đêm, áp dụng khi đơn hàng được đặt trong khoảng thời gian từ 22:00 đến 05:00. Example: 2500
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
     * @param CIntercityRequest $request
     * @return JsonResponse
     */

    public function createCIntercityOrder(CIntercityRequest $request): JsonResponse
    {
        try {
            $response = $this->orderCInterCityService->createCIntercityOrder($request);
            return $this->jsonResponseSuccess(new OrderCIntercityResource($response));
        } catch (Exception $e) {
            $this->logError('Order C_Ride/Car creation failed:', $e);
            return $this->jsonResponseError('Order C_Ride/Car creation failed', 500);
        }
    }

    /**
     * Lấy chi tiết đơn hàng C-Intercity
     *
     * API này dùng để lấy chi tiết đơn hàng C-Intercity dựa trên id đơn hàng.
     *
     * @authenticated
     *
     * @pathParam id int required ID của đơn hàng. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "id": 55,
     *         "code": "90E0EB99",
     *         "driver": {
     *             "id": 4,
     *             "fullname": "Phạm Thị Thanh Thuý",
     *             "phone": "0383476978",
     *             "avatar": "/public/uploads/images/drivers/zjrQ00U2HsdjHRCId7iSpwOWUs8QcJNwab7dwUpS.jpg",
     *             "vehicles": [
     *                 {
     *                     "name": "Wave",
     *                     "license_plate": "ABC-123321"
     *                 }
     *             ]
     *         },
     *         "payment_method": 1,
     *         "sub_total": 2000,
     *         "total": 10000,
     *         "platform_fee": "2000",
     *         "discount_amount": null,
     *         "status": "pending_driver_confirmation",
     *         "order_type": "C_INTERCITY",
     *         "created_at": "27-09-2024 15:40",
     *         "updated_at": "27-09-2024 15:40",
     *         "shipment": {
     *             "start_latitude": 10.839612,
     *             "start_longitude": 106.648021,
     *             "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *             "end_latitude": 10.815832,
     *             "end_longitude": 106.664132,
     *             "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam"
     *         }
     *     }
     * }
     */

    public function show($id): JsonResponse
    {
        try {
            Validator::validateExists($this->repository, $id);

            $order = $this->repository->findOrFail($id);
            return $this->jsonResponseSuccess(new OrderCIntercityResource($order));
        } catch (Exception $e) {
            $this->logError('Order C_Ride/Car show failed:', $e);
            return $this->jsonResponseError('Order C_Ride/Car show failed', 500);
        }
    }
}

<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\DeliveryOrderRequest;
use App\Api\V1\Http\Resources\Order\CDelivery\OrderCDeliveryResource;
use App\Api\V1\Services\Order\CDelivery\OrderCDeliveryServiceInterface;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Validate\Validator;

/**
 * @group Đơn hàng C-Delivery
 */
class CDeliveryOrderController extends Controller
{
    use Response, UseLog;

    protected OrderCDeliveryServiceInterface $cDeliveryService;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface $service,
        OrderCDeliveryServiceInterface $cDeliveryService
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->cDeliveryService = $cDeliveryService;
        $this->middleware('auth:api');
    }

    /**
     * Tạo đơn hàng giao hàng (C-Delivery)
     *
     * API này dùng để tạo đơn hàng giao hàng dựa trên thông tin cung cấp bởi người dùng.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * - advance_payment_status (OpenStatus): Trạng thái của tiền thanh toán trước.
     *   - ON: Tiền thanh toán trước đã được xác nhận.
     *   - OFF: Tiền thanh toán trước chưa được xác nhận.
     *
     * - collection_from_sender_status: Trạng thái thu hộ.
     *   - ON: Trạng thái bật, cho biết rằng tính năng hoặc hành động đang được kích hoạt.
     *   - OFF: Trạng thái tắt, biểu thị rằng tính năng hoặc hành động không được kích hoạt.
     *
     * - payment_role: Định nghĩa vai trò thanh toán trong giao dịch.
     *   - sender: Người gửi hàng sẽ là người thanh toán.
     *   - recipient: Người nhận hàng sẽ là người thanh toán.
     *
     * - delivery_status: Trạng thái giao hàng.
     *   - immediate: Giao hàng ngay lập tức.
     *   - scheduled: Giao hàng theo lịch trình đã đặt.
     *
     *
     * @authenticated
     *
     * @bodyParam start_latitude float required Vĩ độ của điểm bắt đầu. Example: 10.762622
     * @bodyParam start_longitude float required Kinh độ của điểm bắt đầu. Example: 106.660172
     * @bodyParam start_address string required Địa chỉ của điểm bắt đầu. Example: 268 Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh
     * @bodyParam end_latitude float required Vĩ độ của điểm kết thúc. Example: 10.823099
     * @bodyParam end_longitude float required Kinh độ của điểm kết thúc. Example: 106.629664
     * @bodyParam end_address string required Địa chỉ của điểm kết thúc. Example: 2 Phạm Ngọc Thạch, Phường Bến Nghé, Quận 1, Hồ Chí Minh
     * @bodyParam total float required Tổng tiền của đơn hàng. Example: 200000
     * @bodyParam desired_price float optional Giá mong muốn cho đơn hàng. Example: 180000
     * @bodyParam delivery_date date optional Ngày giao hàng. Example: 2024-09-01
     * @bodyParam delivery_time string optional Thời gian giao hàng (định dạng HH:mm). Example: 14:30
     * @bodyParam advance_payment_amount float optional Số tiền thanh toán trước. Example: 50000
     * @bodyParam weight_range_id int required ID phạm vi khối lượng. Example: 3
     * @bodyParam sender_name string required Tên người gửi. Example: Nguyễn Văn A
     * @bodyParam sender_phone string required Số điện thoại người gửi. Example: 0912345678
     * @bodyParam recipient_name string required Tên người nhận. Example: Nguyễn Văn A
     * @bodyParam recipient_phone string required Số điện thoại người nhận. Example: 0912345678
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam note string optional Ghi chú cho đơn hàng. Example: Vui lòng đến đúng giờ
     * @bodyParam platform_fee float optional Phí nền tảng được tính trên mỗi đơn hàng. Example: 10000
     * @bodyParam sub_total float required Tổng phụ trước khi thêm phí và thuế. Example: 190000
     * @bodyParam distance float optional Khoảng cách của chuyến đi tính bằng km. Example: 12.5
     * @bodyParam category_ids array optional Danh sách các ID danh mục liên quan đến đơn hàng. Example: [1, 2, 3]
     * @bodyParam discount_id string optional Mã giảm giá nếu có. Example: DISCOUNT2024
     * @bodyParam advance_payment_status OpenStatus required Trạng thái của tiền thanh toán trước. Example: ON
     * @bodyParam collection_from_sender_status OpenStatus required Trạng thái thu hộ người gửi. Example: OFF
     * @bodyParam payment_role PaymentRole required Trạng thái xác nhận người thanh toán. Example: sender
     * @bodyParam delivery_status DeliveryStatus required Trạng thái giao hàng. Example: immediate
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
     * @param DeliveryOrderRequest $request Yêu cầu từ phía người dùng với các thông tin đơn hàng
     * @return JsonResponse Phản hồi JSON với kết quả thực hiện
     */


    public function createDeliveryOrder(DeliveryOrderRequest $request): JsonResponse
    {
        try {
            $response = $this->cDeliveryService->createDeliveryOrder($request);
            return $this->jsonResponseSuccess(new OrderCDeliveryResource($response));
        } catch (Exception $e) {
            $this->logError('Order delivery creation failed:', $e);
            return $this->jsonResponseError('Order delivery creation failed', 500);
        }
    }

    /**
     * Lấy chi tiết đơn hàng (C-Delivery)
     *
     * API này dùng để lấy chi tiết đơn hàng dựa trên ID của đơn hàng.
     *
     * Phuương thức thanh toán (status) gồm:
     *  - 1: online (Wallet)
     *  - 2: trực tiếp (tiền mặt)
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
            return $this->jsonResponseSuccess(new OrderCDeliveryResource($response));
        } catch (Exception $e) {
            $this->logError('Get order delivery failed:', $e);
            return $this->jsonResponseError('Get order delivery failed', 500);
        }
    }
}

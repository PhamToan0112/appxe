<?php

namespace App\Api\V1\Http\Controllers\Calculation;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Services\Calculation\CalculationServiceInterface;
use App\Api\V1\Exception\NotFoundException;
use App\Api\V1\Http\Requests\Calculation\CalculateCDeliveryRequest;
use App\Api\V1\Http\Requests\Calculation\CalculateCIntercityRequest;
use App\Api\V1\Http\Requests\Calculation\CalculateCMultiRequest;
use App\Api\V1\Http\Requests\Calculation\CRideCar\CalculateBookCarDriverRequest;
use App\Api\V1\Http\Requests\Calculation\CRideCar\CalculateBookCarRequest;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @group Tính Toán Đơn Hàng
 */
class CalculationController extends Controller
{
    use Response, UseLog;

    public function __construct(
        CalculationServiceInterface $service
    )
    {
        $this->service = $service;
    }

    /**
     * Tính toán chi phí cho đơn hàng đặt xe (C-RIDE/CAR)
     *
     * API này dùng để tính toán chi phí cho một đơn hàng đặt xe dựa trên các thông tin đầu vào như tài xế, tọa độ bắt đầu, kết thúc, và mã giảm giá nếu có.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * `order_type` Thể loại đơn hàng:
     *  - C_RIDE: Xe mini
     *  - C_CAR: Xe hơi
     *
     * @authenticated
     *
     * @header Authorization Bearer {token}
     *
     * @bodyParam order_type string required Loại đơn hàng. Example: C_RIDE
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam start_latitude float required Vĩ độ của điểm bắt đầu. Example: 10.762622
     * @bodyParam start_longitude float required Kinh độ của điểm bắt đầu. Example: 106.660172
     * @bodyParam end_latitude float required Vĩ độ của điểm kết thúc. Example: 10.823099
     * @bodyParam end_longitude float required Kinh độ của điểm kết thúc. Example: 106.629664
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam discount_code string optional Mã giảm giá nếu có. Example: DISCOUNT2024
     * @bodyParam order_type string required loại đơn hàng. Example: C_CAR
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "distance": 8.5,
     *         "sub_total": 200000,
     *         "platform_fee": 10000,
     *         "total": 210000,
     *         "discount_amount": 5000
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tính toán chi phí."
     * }
     *
     * @param CalculateBookCarRequest $request
     * @return JsonResponse
     */
    public function calculateBookCarOrder(CalculateBookCarRequest $request): JsonResponse
    {
        try {
            $response = $this->service->calculateBookCarOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Calculation Book Car/Ride failed', $e);
            return $this->jsonResponseError('Calculation failed');
        }
    }

    /**
     * Tính toán chi phí cho đơn hàng C-RIDE-CAR (Tài xế chọn khách hàng)
     *
     * API này dùng để tính toán chi phí cho một đơn hàng đặt xe (C_RIDE_CAR) khi tài xế chọn khách hàng.
     * Các tham số đầu vào sẽ tương tự như đơn hàng đặt xe, nhưng tài xế là người khởi tạo yêu cầu.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * `order_type` Thể loại đơn hàng:
     *  - C_RIDE
     *  - C_CAR
     *
     * @authenticated
     *
     * @header Authorization Bearer {token}
     *
     * @bodyParam order_type string required Loại đơn hàng. Example: C_RIDE
     * @bodyParam id int required ID của đơn hàng. Example: 292
 *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "distance": 8.5,
     *         "sub_total": 200000,
     *         "platform_fee": 10000,
     *         "total": 210000,
     *         "discount_amount": 5000
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tính toán chi phí."
     * }
     *
     * @param CalculateBookCarDriverRequest $request
     * @return JsonResponse
     */
    public function calculateRideCarByDriver(CalculateBookCarDriverRequest $request): JsonResponse
    {
        try {
            $response = $this->service->calculateRideCarByDriver($request);
            return $this->jsonResponseSuccess($response);
        } catch (NotFoundException $e) {
            return $this->jsonResponseError($e->getMessage());
        } catch (Exception $e) {
            $this->logError('Calculation Book Car/Ride failed', $e);
            return $this->jsonResponseError('Calculation failed');
        }
    }


    /**
     * Tính toán chi phí cho đơn hàng giao hàng (C-Delivery)
     *
     * API này dùng để tính toán chi phí cho một đơn hàng giao hàng dựa trên các thông tin đầu vào như tài xế, tọa độ bắt đầu, kết thúc, mã giảm giá (nếu có), và trạng thái giao hàng.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * `delivery_status` Trạng thái giao hàng:
     *  - IMMEDIATE: Giao ngay
     *  - SCHEDULED: Giao theo lịch
     *
     * @authenticated
     *
     * @header Authorization Bearer {token}
     *
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam start_latitude float required Vĩ độ của điểm bắt đầu. Example: 10.762622
     * @bodyParam start_longitude float required Kinh độ của điểm bắt đầu. Example: 106.660172
     * @bodyParam end_latitude float required Vĩ độ của điểm kết thúc. Example: 10.823099
     * @bodyParam end_longitude float required Kinh độ của điểm kết thúc. Example: 106.629664
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam discount_id string optional Mã giảm giá nếu có. Example: DISCOUNT2024
     * @bodyParam weight_range_id int required ID phạm vi trọng lượng. Example: 6
     * @bodyParam delivery_status string required Trạng thái giao hàng. Example: IMMEDIATE
     * @bodyParam advance_payment_amount float required Số tiền thanh toán trước. Example: 0
     * @bodyParam collection_from_sender_status string required Trạng thái thu hộ người gửi. Example: OFF
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "distance": 8.5,
     *         "sub_total": 200000,
     *         "platform_fee": 10000,
     *         "total": 210000,
     *         "discount_amount": 5000
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tính toán chi phí."
     * }
     *
     * @param CalculateCDeliveryRequest $request
     * @return JsonResponse
     */
    public function calculateCDeliveryOrder(CalculateCDeliveryRequest $request): JsonResponse
    {
        try {
            $response = $this->service->calculateCDeliveryOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Calculation Delivery failed', $e);
            return $this->jsonResponseError('Calculation failed');
        }
    }

    /**
     * Tính toán chi phí cho đơn hàng nhiều điểm dừng (CMulti)
     *
     * API này dùng để tính toán chi phí cho một đơn hàng với nhiều điểm dừng dựa trên các thông tin đầu vào như tài xế, danh sách ID các lô hàng, và mã giảm giá nếu có.
     *
     * Phương thức thanh toán (payment_method) gồm:
     * - 1: online (Wallet)
     * - 2: trực tiếp (tiền mặt)
     *
     * @authenticated
     *
     * @header Authorization Bearer {token}
     *
     * @bodyParam driver_id int required ID của tài xế. Example: 5
     * @bodyParam shipment_ids int[] required Mảng ID của các lô hàng. Mỗi ID đại diện cho một điểm dừng. Example: [1, 2, 3]
     * @bodyParam payment_method string required Phương thức thanh toán. Example: 1
     * @bodyParam discount_code string optional Mã giảm giá nếu có. Example: DISCOUNT2024
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "total_distance": 12.5,
     *         "sub_total": 300000,
     *         "platform_fee": 15000,
     *         "total": 315000,
     *         "discount_amount": 10000
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tính toán chi phí."
     * }
     *
     * @param CalculateCMultiRequest $request
     * @return JsonResponse
     */
    public function calculateCMultiOrder(CalculateCMultiRequest $request): JsonResponse
    {
        try {
            $response = $this->service->calculateCMultiOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Calculation CMulti failed', $e);
            return $this->jsonResponseError('Calculation failed', 500);
        }
    }

    /**
     * Tính toán chi phí cho đơn hàng liên thành phố (CIntercity)
     *
     * API này dùng để tính toán chi phí cho một đơn hàng liên thành phố. Tính toán dựa trên thông tin về tài xế, loại hình chuyến đi, và các chi tiết khác như mã giảm giá.
     *
     * @authenticated
     *
     * @header Authorization Bearer {token}
     *
     * @bodyParam quantity int required Số lượng hành khách hoặc đơn vị cần vận chuyển. Ví dụ: 3
     * @bodyParam driver_id int optional ID của tài xế. Ví dụ: 5
     * @bodyParam payment_method string required Phương thức thanh toán, hỗ trợ các giá trị được xác định trong enum PaymentMethod. Ví dụ: "2"
     * @bodyParam trip_type string required Loại hình chuyến đi, hỗ trợ các giá trị được xác định trong enum TripType. Ví dụ: "one_way"
     * @bodyParam route_id int required ID của tuyến đường. Ví dụ: 101
     * @bodyParam discount_id int optional ID của mã giảm giá nếu có. Ví dụ: 2024
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "total_distance": 320.0,
     *         "sub_total": 800000,
     *         "platform_fee": 30000,
     *         "total": 830000,
     *         "discount_amount": 25000
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể tính toán chi phí."
     * }
     *
     * @param CalculateCIntercityRequest $request
     * @return JsonResponse
     */

    public function calculateCIntercityOrder(CalculateCIntercityRequest $request): JsonResponse
    {
        try {
            $response = $this->service->calculateCIntercityOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Calculation CIntercity failed', $e);
            return $this->jsonResponseError('Calculation failed', 500);
        }
    }


}

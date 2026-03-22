<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\CMulti\CMultiOrderRequest;
use App\Api\V1\Http\Requests\Shipment\DeliveryRequest;
use App\Api\V1\Http\Requests\Order\CMulti\ShipmentRequest;
use App\Api\V1\Http\Requests\Order\CMulti\MultiPointOrderDetailRequest;
use App\Api\V1\Http\Requests\Shipment\ShipmentStatusRequest;
use App\Api\V1\Http\Resources\Order\CMulti\OrderCMultiResource;
use App\Api\V1\Http\Resources\Order\CMulti\ShipmentResource;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Services\Order\CMulti\OrderCMultiServiceInterface;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Services\Shipment\ShipmentServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Validate\Validator;


/**
 * @group Đơn hàng đa điểm C-Multi
 */
class CMultiOrderController extends Controller
{
    use Response, UseLog;

    protected ShipmentServiceInterface $shipmentService;

    protected OrderCMultiServiceInterface $orderCMultiService;



    public function __construct(
        OrderRepositoryInterface    $repository,
        OrderServiceInterface       $service,
        ShipmentServiceInterface    $shipmentService,
        OrderCMultiServiceInterface $orderCMultiService,
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->shipmentService = $shipmentService;
        $this->orderCMultiService = $orderCMultiService;
        $this->middleware('auth:api');
    }


    /**
     * Tạo thông tin đơn hàng đa điểm
     *
     * Phương thức này xử lý việc tạo một lô hàng mới dựa trên thông tin được gửi từ client.
     * Thông tin lô hàng bao gồm vị trí bắt đầu, vị trí kết thúc, thông tin người nhận, và các chi tiết khác liên quan đến lô hàng.
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @bodyParam start_latitude float required Vĩ độ của điểm bắt đầu.
     * @bodyParam start_longitude float required Kinh độ của điểm bắt đầu.
     * @bodyParam start_address string required Địa chỉ bắt đầu của lô hàng.
     * @bodyParam end_latitude float required Vĩ độ của điểm kết thúc.
     * @bodyParam end_longitude float required Kinh độ của điểm kết thúc.
     * @bodyParam end_address string required Địa chỉ kết thúc của lô hàng.
     * @bodyParam weight_range_id int required ID khoảng trọng lượng của lô hàng từ bảng `shipping_weight_ranges`.
     * @bodyParam recipient_name string required Tên người nhận lô hàng.
     * @bodyParam recipient_phone string required Số điện thoại người nhận lô hàng.
     * @bodyParam collection_from_sender_status string required Trạng thái thu tiền từ người gửi. Enum: ['on', 'off'].
     * @bodyParam collect_on_delivery_amount float nullable Số tiền thu khi giao hàng.
     * @bodyParam category_ids array nullable Danh sách ID các danh mục liên quan đến lô hàng.
     * @bodyParam category_ids.* int exists:categories,id Mỗi phần tử trong mảng category_ids phải là một ID hợp lệ từ bảng `categories`.
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Tạo lô hàng thành công.",
     *     "data": {
     *         "id": 123,
     *         "start_latitude": 10.7725168,
     *         "start_longitude": 106.6980208,
     *         "start_address": "Địa chỉ bắt đầu",
     *         "end_latitude": 10.7735168,
     *         "end_longitude": 106.6990208,
     *         "end_address": "Địa chỉ kết thúc",
     *         "recipient_name": "Nguyễn Văn B",
     *         "recipient_phone": "0909123456",
     *         "collection_from_sender_status": "on",
     *         "collect_on_delivery_amount": 50000
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Tạo lô hàng không thành công."
     * }
     *
     * @return JsonResponse Trả về kết quả của việc tạo lô hàng dưới dạng JSON.
     */
    public function createShipment(ShipmentRequest $request): JsonResponse
    {
        try {
            $response = $this->shipmentService->store($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Order shipment creation failed:', $e);
            return $this->jsonResponseError('Order shipment creation failed', 500);
        }
    }

    /**
     * Tạo đơn hàng đa điểm
     *
     * Phương thức này xử lý việc gộp nhiều lô hàng vào một đơn hàng dựa trên thông tin được gửi từ client.
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @bodyParam shipment_ids array required Danh sách ID của các lô hàng cần gộp.
     * @bodyParam shipment_ids.* int Mỗi phần tử trong mảng shipment_ids phải là một ID hợp lệ từ bảng `shipments`.
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Các lô hàng đã được gộp vào đơn hàng thành công."
     * }
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể gộp lô hàng vào đơn hàng."
     * }
     *
     * @param CMultiOrderRequest $request
     * @return JsonResponse
     */
    public function mergeShipmentsIntoOrder(CMultiOrderRequest $request): JsonResponse
    {
        try {

            $response = $this->orderCMultiService->createCMultiOrder($request);

            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('mergeShipmentsIntoOrder error:', $e);
            return $this->jsonResponseError('Order shipment creation failed', 500);
        }
    }

    /**
     * Giao hàng thành công - upload hình ảnh trả hàng và ID của shipment
     *
     * Phương thức này dùng để upload hình ảnh trả hàng và liên kết với lô hàng (`shipment_id`).
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @bodyParam shipment_id int required ID của lô hàng. Example: 123
     * @bodyParam return_image file required Ảnh trả hàng (định dạng: jpeg, png, jpg, gif). Example: return_image.jpg
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Giao hàng thành công và upload hình ảnh trả hàng.",
     *     "data": {
     *         "shipment_id": 123,
     *         "return_image_url": "http://example.com/images/return_image.jpg"
     *     }
     * }
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể upload hình ảnh trả hàng."
     * }
     *
     * @param DeliveryRequest $request
     * @return JsonResponse
     */
    public function completeShipment(DeliveryRequest $request): JsonResponse
    {
        try {
            $response = $this->orderCMultiService->completeShipment($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            return $this->jsonResponseError('return image error', 500);
        }
    }


    /**
     * Chuyển trạng thái lô hàng sang Chuẩn bị/Xoá
     *
     * Các trạng thái (status) của đơn hàng bao gồm:
     *  - preparing:Chuẩn bị
     *  - deleted: Xoá
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @bodyParam shipment_ids array required Danh sách ID của các lô hàng. Example: [123, 124, 125]
     * @bodyParam status string required Trạng thái cần chuyển. Example: preparing
     *
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Trạng thái lô hàng đã chuyển sang 'Chuẩn bị'.",
     *     "data": {
     *         "shipment_id": 123,
     *         "status": "preparing"
     *     }
     * }
     * @response 400 {
     *     "status": 400,
     *     "message": "Lô hàng không tồn tại."
     * }
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể chuyển trạng thái lô hàng."
     * }
     *
     * @param ShipmentStatusRequest $request
     * @return JsonResponse
     */
    public function updateShipmentStatusToPreparing(ShipmentStatusRequest $request): JsonResponse
    {
        try {
            $this->orderCMultiService->updateShipmentStatusToPreparing($request);
            return $this->jsonResponseSuccess([]);
        } catch (Exception $e) {
            $this->logError('Update shipment status error', $e);
            return $this->jsonResponseError('Update shipment status error', 500);
        }
    }

    /**
     * Cập nhật trạng thái chi tiết đơn hàng đa điểm
     *
     * Các trạng thái (delivery_status) của đơn hàng bao gồm:
     *  - pending: Đang chờ
     *  - delivering: Đang giao
     *  - delivered: Đã đến
     *  - completed: Đã giao
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @bodyParam multi_point_detail_id array required Danh sách ID của chi tiết đơn hàng đa điểm. Example: [123, 124, 125]
     * @bodyParam delivery_status string required Trạng thái cần chuyển. Example: delivering
     *
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Trạng thái chi tiết đơn đã chuyển sang 'Đang giao'.",
     *     "data": {
     *         "multi_point_detail_id": 123,
     *         "status": "preparing"
     *     }
     * }
     * @response 400 {
     *     "status": 400,
     *     "message": "chi tiết đơn không tồn tại."
     * }
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể chuyển trạng thái chi tiết đơn."
     * }
     *
     * @param MultiPointOrderDetailRequest $request
     * @return JsonResponse
     */
    public function updateMultiPointOrderDetailStatus(MultiPointOrderDetailRequest $request): JsonResponse
    {
        try {
            $this->orderCMultiService->updateMultiPointOrderDetailStatus($request);
            return $this->jsonResponseSuccess([]);
        } catch (Exception $e) {
            $this->logError('Update order multi point details status error', $e);
            return $this->jsonResponseError('Update order multi point details status error', 500);
        }
    }

    /**
     * Xoá vĩnh viễn lô hàng
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     *
     * @bodyParam shipment_ids array required Danh sách ID của các lô hàng. Example: [123, 124, 125]
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công."
     *   }
     *
     * @response 500 {
     *   "status": 500,
     *   "message": "Delete shipment error"
     *   }
     */

    public function deleteShipments(ShipmentRequest $request): JsonResponse
    {
        try {
            $this->shipmentService->delete($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Delete shipment error', $e);
            return $this->jsonResponseError('Delete shipment error', 500);
        }
    }

    /**
     * Lấy DS thông tin đơn hàng đa điểm
     *
     * Các trạng thái - type của loại đơn hàng để lọc bao gồm:
     *  - preparing:  Đơn hàng đang chuẩn bị
     *  - draft: Đơn hàng bản nháp
     *  - unsorted: Đơn hàng chưa phân loại
     *  - ordered: Đơn hàng đã lên đơn
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @queryParam type required optional Loại đơn hàng để lọc. Example: draft
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": [
     *         {
     *             "id": 44,
     *             "code": "11857CFE",
     *             "driver": {
     *                 "id": 2,
     *                 "fullname": "Trần Quốc Hùng",
     *                 "phone": "0383476961",
     *                 "avatar": "/public/uploads/images/drivers/arnOuxmPrWUASSz1zb0T5YmYrjz6splKrJJUJJnA.jpg",
     *                 "vehicles": [
     *                     {
     *                         "name": "Wave",
     *                         "license_plate": "ABC-12341"
     *                     }
     *                 ]
     *             },
     *             "payment_method": 1,
     *             "sub_total": null,
     *             "total": 10000,
     *             "platform_fee": "2000",
     *             "discount_amount": null,
     *             "status": "pending",
     *             "order_type": "C_MULTI",
     *             "created_at": "26-09-2024 20:14",
     *             "updated_at": "26-09-2024 20:14",
     *             "order_multi_points": [
     *                 {
     *                     "weight_range": {
     *                         "min_weight": "0",
     *                         "max_weight": "5"
     *                     },
     *                     "start_latitude": 10.839612,
     *                     "start_longitude": 106.648021,
     *                     "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *                     "end_latitude": 10.815832,
     *                     "end_longitude": 106.664132,
     *                     "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam",
     *                     "recipient_name": "Nguyễn Trí Thành",
     *                     "recipient_phone": "0383476555",
     *                     "collect_on_delivery_amount": "120000"
     *                 },
     *                 {
     *                     "weight_range": {
     *                         "min_weight": "0",
     *                         "max_weight": "5"
     *                     },
     *                     "start_latitude": 10.839612,
     *                     "start_longitude": 106.648021,
     *                     "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *                     "end_latitude": 10.815832,
     *                     "end_longitude": 106.664132,
     *                     "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam",
     *                     "recipient_name": "Nguyễn Trí Thành",
     *                     "recipient_phone": "0383476555",
     *                     "collect_on_delivery_amount": "120000"
     *                 }
     *             ]
     *         }
     *     ]
     * }
     */

    public function getShipments(ShipmentRequest $request): JsonResponse
    {
        try {
            $shipments = $this->orderCMultiService->getShipments($request);

            return $this->jsonResponseSuccess(ShipmentResource::collection($shipments));
        } catch (Exception $e) {
            $this->logError('Get shipment error', $e);
            return $this->jsonResponseError('Get shipment error', 500);
        }
    }


    /**
     * Chi tiết đơn hàng đa điểm
     *
     * Phương thức này xử lý việc lấy thông tin chi tiết của một đơn hàng đa điểm dựa trên ID của đơn hàng.
     *
     * @authenticated
     * @headersParam X-TOKEN-ACCESS string required Token để xác thực người dùng.
     * @pathParam id int required ID của đơn hàng. Example: 123
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": [
     *         {
     *             "id": 44,
     *             "code": "11857CFE",
     *             "driver": {
     *                 "id": 2,
     *                 "fullname": "Trần Quốc Hùng",
     *                 "phone": "0383476961",
     *                 "avatar": "/public/uploads/images/drivers/arnOuxmPrWUASSz1zb0T5YmYrjz6splKrJJUJJnA.jpg",
     *                 "vehicles": [
     *                     {
     *                         "name": "Wave",
     *                         "license_plate": "ABC-12341"
     *                     }
     *                 ]
     *             },
     *             "payment_method": 1,
     *             "sub_total": null,
     *             "total": 10000,
     *             "platform_fee": "2000",
     *             "discount_amount": null,
     *             "status": "pending",
     *             "order_type": "C_MULTI",
     *             "created_at": "26-09-2024 20:14",
     *             "updated_at": "26-09-2024 20:14",
     *             "order_multi_points": [
     *                 {
     *                     "weight_range": {
     *                         "min_weight": "0",
     *                         "max_weight": "5"
     *                     },
     *                     "start_latitude": 10.839612,
     *                     "start_longitude": 106.648021,
     *                     "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *                     "end_latitude": 10.815832,
     *                     "end_longitude": 106.664132,
     *                     "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam",
     *                     "recipient_name": "Nguyễn Trí Thành",
     *                     "recipient_phone": "0383476555",
     *                     "collect_on_delivery_amount": "120000"
     *                 },
     *                 {
     *                     "weight_range": {
     *                         "min_weight": "0",
     *                         "max_weight": "5"
     *                     },
     *                     "start_latitude": 10.839612,
     *                     "start_longitude": 106.648021,
     *                     "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *                     "end_latitude": 10.815832,
     *                     "end_longitude": 106.664132,
     *                     "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam",
     *                     "recipient_name": "Nguyễn Trí Thành",
     *                     "recipient_phone": "0383476555",
     *                     "collect_on_delivery_amount": "120000"
     *                 }
     *             ]
     *         }
     *     ]
     * }
     */

    public function show($id): JsonResponse
    {
        try {
            Validator::validateExists($this->repository, $id);
            $response = $this->repository->findOrFail($id);
            $dataRes = new OrderCMultiResource($response);

            return $this->jsonResponseSuccess($dataRes);
        } catch (Exception $e) {
            $this->logError('Show order error', $e);
            return $this->jsonResponseError('Show order error', 500);
        }
    }
}

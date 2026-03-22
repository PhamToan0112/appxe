<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Http\Requests\Order\AssignDriverRequest;
use App\Api\V1\Http\Requests\Order\CheckOrderRequest;
use App\Api\V1\Http\Requests\Order\CRideCar\OrderCRideCarRequest;
use App\Api\V1\Http\Requests\Order\LocationRequest;
use App\Api\V1\Http\Requests\Order\OrderActiveRequest;
use App\Api\V1\Http\Requests\Order\OrderNoDriverRequest;
use App\Api\V1\Http\Requests\Order\OrderRequest;
use App\Api\V1\Http\Requests\Order\OrderSearchResourceCollection;
use App\Api\V1\Http\Requests\Order\SelectCustomerRequest;
use App\Api\V1\Http\Requests\Order\UploadOrderConfirmationImageRequest;
use App\Api\V1\Http\Resources\Order\OrderActiveResource;
use App\Api\V1\Http\Resources\Order\OrderNoDriverResource;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Enums\OpenStatus;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Đơn hàng
 */
class OrderController extends Controller
{
    use Response, UseLog, AuthServiceApi;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        UserRepositoryInterface  $userRepository,
        OrderServiceInterface    $service
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->middleware('auth:api');
    }

    /**
     * Kiểm tra khả năng tạo đơn hàng mới của người dùng.
     *
     * API này dùng để kiểm tra xem người dùng hiện tại có thể tạo đơn hàng mới hay không,
     * dựa trên các đơn hàng hiện tại của họ có đang trong trạng thái không hoàn thành hoặc không bị hủy.
     *
     * `order_type` Thể loại đơn hàng:
     *  - C_RIDE
     *  - C_CAR
     *  - C_DELIVERY
     *
     * @authenticated
     * @bodyParam order_type string required loại đơn hàng. Example: C_RIDE
     *
     * @return JsonResponse Trả về JsonResponse để thông báo kết quả của quá trình kiểm tra.
     *
     * @response 200 {
     *     "status": "success",
     *     "message": "Người dùng có thể tạo đơn hàng mới.",
     *     "data": []
     * }
     *
     * @response 400 {
     *     "status": "error",
     *     "message": "Không thể tạo đơn hàng mới do có đơn hàng đang xử lý."
     * }
     *
     * @response 500 {
     *     "status": "error",
     *     "message": "Lỗi hệ thống khi kiểm tra đơn hàng."
     * }
     */

    public function canPlaceOrder(CheckOrderRequest $request): JsonResponse
    {
        try {
            $this->service->checkCreateOrder($request);
            return $this->jsonResponseSuccessNoData();
        } catch (BadRequestException $e) {
            return $this->jsonResponseError($e->getMessage());
        } catch (Throwable $e) {
            $this->logError('Check Order create error', $e);
            return $this->jsonResponseError('Check Order create error', 500);
        }
    }

    /**
     * Lấy danh sách đơn hàng đang diễn ra của người dùng hiện tại C-RIDE/CAR?DELIVERY.
     *
     * API này trả về danh sách các đơn hàng của người dùng hiện tại mà không ở trạng thái 'completed' hoặc 'cancelled'.
     * Điều này bao gồm các đơn hàng đang chờ xác nhận, đang vận chuyển, hoặc bất kỳ trạng thái nào khác mà không phải là đã hoàn thành hoặc đã hủy.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Lấy danh sách đơn hàng thành công.",
     *     "data": [
     *         {
     *             "id": 1,
     *             "user_id": 5,
     *             "status": "in_transit",
     *             "created_at": "2021-01-01 12:00:00",
     *             "updated_at": "2021-01-01 12:00:00"
     *         },
     *         {
     *             "id": 2,
     *             "user_id": 5,
     *             "status": "pending_customer_confirmation",
     *             "created_at": "2021-02-01 12:00:00",
     *             "updated_at": "2021-02-01 12:00:00"
     *         }
     *     ]
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy đơn hàng nào đang diễn ra."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống khi lấy danh sách đơn hàng."
     * }
     *
     * @param OrderActiveRequest $request
     * @return JsonResponse
     */
    public function getActiveOrders(OrderActiveRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getOrderActive($request);
            return $this->jsonResponseSuccess(OrderActiveResource::collection($response));
        } catch (Exception $e) {
            $this->logError('Error retrieving active orders:', $e);
            return $this->jsonResponseError('Lỗi hệ thống khi lấy danh sách đơn hàng.', 500);
        }
    }

    public function getOrdersWithoutDriver(OrderNoDriverRequest $request): JsonResponse
    {
        try {
            $user = $this->getCurrentUser();
            if ($user->active == OpenStatus::ON) {
                $response = $this->service->getOrdersWithoutDriver($request);
                return $this->jsonResponseSuccess(OrderNoDriverResource::collection($response));
            }
            return $this->jsonResponseSuccess([]);

        } catch (Exception $e) {
            $this->logError('Error get no driver orders:', $e);
            return $this->jsonResponseError('Lỗi hệ thống khi lấy danh sách đơn hàng.', 500);
        }
    }


    /**
     * Cập nhật trạng thái đơn hàng
     *
     * Các trạng thái của đơn hàng bao gồm:
     * - pending_driver_confirmation: Chờ tài xế xác nhận
     * - pending_customer_confirmation: Chờ khách hàng xác nhận
     * - in_transit: Đơn hàng đang di chuyển
     * - completed: Đơn hàng đã hoàn thành
     * - cancelled: Đơn hàng đã bị hủy
     * - failed: Đơn hàng không thành công
     * - driver_canceled: Tài xế đã hủy
     * - customer_canceled: Khách hàng đã hủy
     * - customer_confirmed: khách hàng đã xác nhận
     *
     * Các phương thức thanh toán bao gồm:
     *    - 1: Thanh toán online (Wallet)
     *    - 2: Thanh toán trực tiếp (Direct)
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam code string required Code của đơn hàng. Example: 0B96C67F
     * @bodyParam status integer required Trạng thái mới của đơn hàng. Example: picking_up
     * @bodyParam reason_cancel string required Lý do hủy đơn hàng. Example: "Khách hàng không muốn nhận hàng"
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "notifySuccess",
     *      "data": []
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "notifyError",
     *      "data": []
     * }
     *
     * @response 404 {
     *      "status": 404,
     *      "message": "Order not found",
     *      "data": []
     * }
     *
     * @param OrderRequest $request
     * @return JsonResponse
     */

    public function updateStatus(OrderRequest $request): JsonResponse
    {
        try {
            $this->service->updateStatus($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Throwable $e) {
            $this->logError('Error while updating order status:', $e);
            return $this->jsonResponseError('Error while updating order status', 400);
        }
    }

    /**
     * Phân công tài xế cho đơn hàng C-Ride/Car
     *
     * API này dùng để phân công tài xế cho một đơn hàng cụ thể. Tài xế được phân công dựa trên ID đã cung cấp.
     *
     * @authenticated
     * @bodyParam code string required Mã đơn hàng. Example: ODR123456789
     * @bodyParam driver_id integer required ID của tài xế sẽ được phân công. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Tài xế đã được phân công thành công cho đơn hàng.",
     *     "data": {
     *         "order_code": "ODR123456789",
     *         "driver_id": 5
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ hoặc không đủ điều kiện để thực hiện."
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy đơn hàng hoặc tài xế.",
     *     "errors": {
     *         "order": "Đơn hàng không tồn tại.",
     *         "driver": "Tài xế không tồn tại."
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống không thể phân công tài xế."
     * }
     *
     * @param AssignDriverRequest $request Đối tượng request chứa dữ liệu validation.
     * @return JsonResponse
     */
    public function assignDriverToOrder(AssignDriverRequest $request): JsonResponse
    {
        try {
            $response = $this->service->assignDriverToOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Throwable $e) {
            $this->logError('Error while assigning driver to order:', $e);
            return $this->jsonResponseError('Error while assigning driver to order', 400);
        }

    }

    /**
     * Chọn khách hàng cho đơn hàng C-Ride/Car
     *
     * API này dùng để cho phép tài xế chọn khách hàng cho một đơn hàng cụ thể.
     * Việc chọn khách hàng có thể dựa trên các tiêu chí như vị trí của khách hàng hoặc các yêu cầu đặc biệt khác.
     *
     * @authenticated
     *
     * @bodyParam order_id int required ID của đơn hàng mà tài xế muốn chọn khách hàng. Example: 101
     * @bodyParam driver_id int required ID của tài xế. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Khách hàng đã được chọn thành công cho đơn hàng.",
     *     "data": {
     *         "order_id": 101,
     *         "customer_id": 25
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ hoặc không đủ điều kiện để thực hiện."
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy đơn hàng hoặc khách hàng.",
     *     "errors": {
     *         "order": "Đơn hàng không tồn tại.",
     *         "customer": "Khách hàng không tồn tại."
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống không thể chọn khách hàng."
     * }
     *
     * @param SelectCustomerRequest $request Đối tượng request chứa dữ liệu validation.
     * @return JsonResponse
     */
    public function selectCustomerForOrder(SelectCustomerRequest $request): JsonResponse
    {
        try {
            $response = $this->service->selectCustomerForOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Throwable $e) {
            $this->logError('Error while selecting customer for order:', $e);
            return $this->jsonResponseError('Error while selecting customer for order', 400);
        }
    }


    /**
     * Xoá đơn hàng
     *
     * API này dùng để Xoá đơn hàng
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @pathParam id int required ID của đơn hàng cần xoá. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "ERROR."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $result = $this->service->delete($id);
            if ($result) {
                return $this->jsonResponseSuccessNoData();
            }
            return $this->jsonResponseError();
        } catch (Exception $e) {
            $this->logError('Order delete failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Tải lên hình ảnh xác nhận đơn hàng
     *
     * @authenticated
     * @bodyParam id int required ID của đơn hàng.
     * @bodyParam order_confirmation_image string required Hình ảnh xác nhận đơn hàng.
     *
     * @response {
     *   "status": 200,
     *   "message": "Hình ảnh đã được tải lên thành công.",
     *   "image_url": "url_to_image"
     * }
     *
     * @response 400 {
     *   "status": 400,
     *   "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *   "status": 500,
     *   "message": "Lỗi hệ thống. Không thể tải lên hình ảnh."
     * }
     *
     * @param UploadOrderConfirmationImageRequest $request
     * @return JsonResponse
     */
    public function uploadOrderConfirmationImage(UploadOrderConfirmationImageRequest $request): JsonResponse
    {
        try {
            $response = $this->service->uploadOrderConfirmationImage($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Failed to upload order confirmation image:', $e);
            return $this->jsonResponseError('Failed to upload image.', 500);
        }
    }

    /**
     * Báo cáo đơn hàng
     *
     * API này dùng để báo cáo đơn hàng. Trả về hình ảnh và cập nhật trạng thái đơn hàng thành Đã trả hàng
     *
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @bodyParam order_id int required ID của đơn hàng. Example: 4.
     * @bodyParam reports array required Nội dung báo cáo đơn hàng. Example: "nội dung 1", "nội dung 2" .
     * @bodyParam return_image image required Hình ảnh trả về. Example: "public/uploads/images/orders//d2J3cF7CTCITzopIoVmCLWJcwlwjrqK615hrkOvf.jpg"
     *
     * @response {
     *   "status": 200,
     *   "message": "Thực hiện thành công.",
     *   "data": [
     *          {
     *             "order_id": 4,
     *             "description": "nội dung 1"
     *          },
     *          {
     *             "order_id": 4,
     *             "description": "nội dung 1"
     *          }
     *      ]
     * }
     *
     * @response 500 {
     *   "status": 500,
     *   "message": "Lỗi hệ thống. Không thể tải lên báo cáo đơn hàng."
     * }
     *
     * @param OrderRequest $request
     * @return JsonResponse
     */
    public function reportOrderIssues(OrderRequest $request): JsonResponse
    {
        try {
            $response = $this->service->reportOrderIssues($request);

            if ($response === false) {
                return $this->jsonResponseError('Failed to upload report.', 500);
            }
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Failed to upload order:', $e);
            return $this->jsonResponseError('Failed to upload report.', 500);
        }
    }


    /**
     * Lấy danh sách đơn hàng theo người dùng
     *
     * Phương thức này dùng để lấy danh sách các đơn hàng liên quan đến người dùng hiện tại,
     * dựa trên vai trò của họ như là khách hàng hoặc tài xế. Người dùng có thể lọc danh sách
     * theo loại đơn hàng và trạng thái của đơn hàng.
     *
     * - `order_type`: Loại đơn hàng xác định mục đích sử dụng của đơn hàng. Các giá trị có thể:
     *   - `C_RIDE`: Đơn hàng dành cho dịch vụ đặt xe di chuyển ngay.
     *   - `C_CAR`: Đơn hàng đặt xe theo yêu cầu đặc biệt hoặc đặt trước.
     *   - `C_INTERCITY`: Đơn hàng cho dịch vụ di chuyển liên thành phố.
     *   - `C_DELIVERY`: Đơn hàng dành cho dịch vụ giao hàng.
     *   - `C_MULTI`: Đơn hàng đa điểm.
     *
     * - `status`: Trạng thái của đơn hàng phản ánh quá trình xử lý đơn hàng:
     *   - `completed`: Đơn hàng đã hoàn thành.
     *   - `driver_confirmed`: Tài xế xác nhận.
     *   - `cancelled`: Đơn hàng đã bị hủy bỏ.
     *   - `failed`: Đơn hàng không thành công do một số lý do.
     *
     * @authenticated
     *
     * @queryParam page int required Trang hiện tại của danh sách phân trang. Example: 1
     * @queryParam limit int optional Giới hạn số lượng đơn hàng trên mỗi trang. Example: 10
     * @queryParam order_type required optional Loại đơn hàng để lọc. Example: C_Ride
     * @queryParam status string optional Trạng thái của đơn hàng để lọc. Example: completed
     *
     * @response {
     *     "status": 200,
     *     "message": "Lấy dữ liệu thành công.",
     *     "data": {
     *         "orders": [
     *             {
     *                 "id": 10,
     *                 "user_id": 5,
     *                 "driver_id": 1,
     *                 "order_type": "C_Ride",
     *                 "status": "completed",
     *                 "created_at": "2021-01-01 12:00:00",
     *                 "updated_at": "2021-01-01 12:00:00"
     *             }
     *         ],
     *         "pagination": {
     *             "total": 50,
     *             "count": 10,
     *             "per_page": 10,
     *             "current_page": 1,
     *             "total_pages": 5
     *         }
     *     }
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin yêu cầu không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống."
     * }
     *
     * @param OrderCRideCarRequest $request Đối tượng request chứa dữ liệu validation.
     * @return JsonResponse
     */


    public function getOrderByUser(OrderCRideCarRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getOrderByUser($request);
            return $this->jsonResponseSuccess(new OrderSearchResourceCollection($response));
        } catch (Exception $e) {
            $this->logError('Order get by driver failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Cập nhật vị trí hiện tại của đơn hàng.
     *
     * API này cho phép cập nhật vị trí hiện tại của đơn hàng dựa trên địa chỉ hiện tại và thông tin GPS.
     * Yêu cầu này đòi hỏi phải có ID của đơn hàng, địa chỉ hiện tại và tọa độ GPS.
     *
     * @authenticated
     * @param LocationRequest $request Đối tượng yêu cầu chứa các quy tắc xác thực và thông tin cần thiết để cập nhật vị trí.
     *
     * @return JsonResponse
     * @bodyParam id integer required ID đơn hàng. Phải tồn tại trong bảng `orders`. Example: 5
     * @bodyParam current_address string required Địa chỉ hiện tại nơi đơn hàng đang có mặt. Example: "123 Đường ABC, Quận 1, TP. HCM"
     * @bodyParam current_lat float required Vĩ độ GPS của vị trí hiện tại. Example: 10.776889
     * @bodyParam current_lng float required Kinh độ GPS của vị trí hiện tại. Example: 106.700806
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Vị trí đơn hàng đã được cập nhật thành công.",
     *      "data": {
     *          "order_detail": {
     *              "id": 5,
     *              "current_address": "123 Đường ABC, Quận 1, TP. HCM",
     *              "current_lat": 10.776889,
     *              "current_lng": 106.700806
     *          }
     *      }
     * }
     *
     * @response 404 {
     *      "status": 404,
     *      "message": "Không tìm thấy đơn hàng",
     *      "data": []
     * }
     *
     * @response 500 {
     *      "status": 500,
     *      "message": "Lỗi khi cập nhật vị trí đơn hàng",
     *      "data": []
     * }
     */
    public function updateLocation(LocationRequest $request): JsonResponse
    {
        try {
            $response = $this->service->updateLocation($request);
            return $this->jsonResponseSuccess($response);
        } catch (Throwable $e) {
            $this->logError('Error updating order location', $e);
            return $this->jsonResponseError('Lỗi khi cập nhật vị trí đơn hàng: ' . $e->getMessage(), 500);
        }

    }
}

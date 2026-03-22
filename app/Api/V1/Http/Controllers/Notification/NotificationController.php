<?php

namespace App\Api\V1\Http\Controllers\Notification;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Notification\NotificationRequest;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Http\Resources\Notification\NotificationResource;
use App\Api\V1\Http\Resources\Notification\ShowNotificationResource;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Validate\Validator;
use Exception;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;

/**
 * @group Thông báo
 */

class NotificationController extends Controller
{
    use AuthServiceApi, Response, UseLog;

    protected NotificationRepositoryInterface $notiRepository;
    protected UserRepositoryInterface $userRepository;
    protected DriverRepositoryInterface $driverRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        NotificationServiceInterface $service,
        UserRepositoryInterface $userRepository,
        DriverRepositoryInterface $driverRepository,

    ) {
        $this->notiRepository = $repository;
        $this->service = $service;
        $this->userRepository = $userRepository;
        $this->driverRepository = $driverRepository;
    }
    /**
     * DS thông báo
     *
     * DS thông báo và sắp xếp theo thứ tự giảm dần
     *
     * Trạng thái thông báo (status) gồm:
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam page integer
     * Trang hiện tại, page > 0. Example: 1
     *
     * @queryParam limit integer
     * Số lượng bài viết trong 1 trang, limit > 0. Example: 1
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công.",
     *    "data": [
     *        {
     *          "id": 54,
     *          "title": "Thông báo cho khách hàng Phạm Thị Kim Ngân",
     *          "message": "Thông báo cho khách hàng Phạm Thị Kim Ngân",
     *          "status": 1,
     *          "created_at": "28-08-2024 09:59"
     *        }
     *    ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NotificationRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getNotifications($request);
            return $this->jsonResponseSuccess(new NotificationResource($response));
        } catch (Exception $e) {
            $this->logError('Get user notifications failed:', $e);
            return $this->jsonResponseError('Get user notifications failed', 500);
        }
    }
    /**
     * Chi tiết thông báo
     *
     * Chi tiết thông báo
     *
     * Trạng thái thông báo (status) gồm:
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * Thông báo gồn các loại (type):
     * - unclassified: Chưa phân loại
     * - deposit: Thông báo nạp tiền
     * - withdraw: Thông báo rút tiền
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id integer required
     * ID thông báo. Example: 1
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công.",
     *    "data": [
     *        {
     *          "id": 54,
     *          "title": "Thông báo cho tài xế Nguyễn Minh Huy",
     *          "message": "Thông báo cho tài xế Nguyễn Minh Huy",
     *          "status": 1,
     *          "created_at": "28-08-2024 09:59"
     *        }
     *    ]
     * }
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {
            Validator::validateExists($this->notiRepository, $id);
            $response = $this->service->detail($id);
            return $this->jsonResponseSuccess(new ShowNotificationResource($response));

        } catch (Exception $e) {
            $this->logError('Get notification failed:', $e);
            return $this->jsonResponseError('Get notification failed', 500);
        }
    }
    /**
     * Đánh dấu thông báo đã đọc
     *
     * Đánh dấu thông báo đã đọc
     *
     * Trạng thái thông báo (status) gồm:
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id integer required
     * ID thông báo. Example: 1
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công.",
     *    "data": ["Mark as read notification successfully"],
     * }
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsRead( $id): JsonResponse
    {
        try {
            Validator::validateExists($this->notiRepository, $id);

            $this->service->markAsRead($id);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Mark as read notification failed:', $e);
            return $this->jsonResponseError('Mark as read notification failed', 500);
        }
    }
    /**
     * Xoá thông báo
     *
     * Xoá thông báo
     *
     * Trạng thái thông báo (status) gồm:
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id integer required
     * ID thông báo. Example: 1
     *
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công.",
     *    "data": ["Delete notification successfully"],
     * }
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteNotification($id): JsonResponse
    {
        try {
            Validator::validateExists($this->notiRepository, $id);
            $this->repository->delete($id);
            return $this->jsonResponseSuccess('Delete notification successfully');
        } catch (Exception $e) {
            $this->logError('Delete notification failed:', $e);
            return $this->jsonResponseError('Delete notification failed', 500);
        }
    }
}

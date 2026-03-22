<?php

namespace App\Api\V1\Http\Controllers\User;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\User\LocationRecentRequest;
use App\Api\V1\Http\Requests\User\UserRegisterRequest;
use App\Api\V1\Http\Requests\User\UserSearchRequest;
use App\Api\V1\Http\Requests\User\UserUpdateRequest;
use App\Api\V1\Http\Resources\Auth\AuthResource;
use App\Api\V1\Http\Resources\User\{UserAllResourceCollection, UserRecentLocationResource, UserConfigurationResource};
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\User\UserServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;
use App\Api\V1\Support\AuthServiceApi;


/**
 * @group Khách hàng
 */
class UserController extends Controller
{
    use AuthServiceApi, Response, UseLog;

    private static string $GUARD_API = 'api';

    public function __construct(
        UserRepositoryInterface $repository,
        UserServiceInterface    $service
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    /**
     * Đăng ký người dùng
     *
     * API này cho phép người dùng mới đăng ký bằng cách cung cấp các chi tiết cần thiết như email, tên đầy đủ, mật khẩu và số điện thoại.
     *
     * @bodyParam email string required Địa chỉ email của người dùng. Example: user@example.com
     * @bodyParam fullname string required Tên đầy đủ của người dùng. Example: John Doe
     * @bodyParam password string required Mật khẩu của tài khoản. Example: password123
     * @bodyParam password_confirmation string required Xác nhận mật khẩu. Example: password123
     * @bodyParam phone string required Số điện thoại của người dùng. Example: 0961592551
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "User registered successfully.",
     *     "data": {
     *         "id": 1,
     *         "email": "user@example.com",
     *         "fullname": "John Doe",
     *         "phone": "0961592551"
     *     }
     * }
     *
     * @response 422 {
     *     "status": 422,
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "email": ["The email has already been taken."],
     *         "phone": ["The phone format is invalid."]
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "User creation failed due to a server error."
     * }
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            $response = $this->service->store($request);

            return $this->jsonResponseSuccess($response);
        } catch (Throwable $e) {
            $this->logError('User creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }


    /**
     * Cập nhật thông tin người dùng
     *
     * API này cho phép người dùng cập nhật thông tin cá nhân của họ. Điều này bao gồm tên đầy đủ, số tài khoản ngân hàng, mã ngân hàng, số điện thoại và địa chỉ email.
     *
     * @authenticated
     * @bodyParam fullname string required Tên đầy đủ mới của người dùng. Example: Jane Doe
     * @bodyParam bank_account_number string required Số tài khoản ngân hàng mới. Example: 123456789
     * @bodyParam bank_id int required ID của ngân hàng liên kết với tài khoản. Example: 1
     * @bodyParam phone string optional Số điện thoại mới của người dùng, phải là số điện thoại hợp lệ. Example: 0977123456
     * @bodyParam email string optional Địa chỉ email mới của người dùng. Example: newuser@example.com
     * @bodyParam avatar string optional Đường dẫn hình ảnh đại diện mới, nếu cập nhật. Example: http://example.com/avatar.jpg
     * @bodyParam gender string optional Giới tính, nếu cập nhật. Example: 1
     * @bodyParam birthday string optional Ngày sinh, nếu cập nhật. Example: 2024-12-12
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thông tin người dùng đã được cập nhật thành công.",
     *     "data": {
     *         "id": 1,
     *         "fullname": "Jane Doe",
     *         "bank_account_number": "123456789",
     *         "bank_id": 1,
     *         "phone": "0977123456",
     *         "email": "newuser@example.com",
     *         "avatar": "http://example.com/avatar.jpg"
     *     }
     * }
     *
     * @response 422 {
     *     "status": 422,
     *     "message": "Dữ liệu không hợp lệ",
     *     "errors": {
     *         "phone": ["Số điện thoại đã được sử dụng."],
     *         "email": ["Địa chỉ email đã được sử dụng."]
     *     }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Không thể cập nhật thông tin người dùng do lỗi server."
     * }
     *
     * @param UserUpdateRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        try {
            $response = $this->service->update($request);

            return $this->jsonResponseSuccess(new AuthResource($response));
        } catch (Throwable $e) {
            $this->logError('User creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Địa chỉ gần đây của khách hàng
     *
     * Địa chỉ gần đây của khách hàng
     *
     * - `type`: Loại đơn hàng xác định mục đích sử dụng của đơn hàng. Các giá trị có thể:
     *   - `C_RIDE`: Đơn hàng dành cho dịch vụ đặt xe di chuyển ngay.
     *   - `C_CAR`: Đơn hàng đặt xe theo yêu cầu đặc biệt hoặc đặt trước.
     *   - `C_INTERCITY`: Đơn hàng cho dịch vụ di chuyển liên thành phố.
     *   - `C_DELIVERY`: Đơn hàng dành cho dịch vụ giao hàng.
     *   - `C_MULTI`: Đơn hàng đa điểm.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @queryParam type required optional Loại đơn hàng để lọc. Example: C_Ride
     *
     * @response 200 {
     *       "status": 200,
     *       "message": "Thực hiện thành công.",
     *       "data": {
     *           "id": 1,
     *           "user_id": 1,
     *           "start_latitude": 10.839612,
     *           "start_longitude": 106.648021,
     *           "start_address": "Hẻm 972 Quang Trung, Phường 8, Gò Vấp, Hồ Chí Minh, Việt Nam",
     *           "end_latitude": 10.815832,
     *           "end_longitude": 106.664132,
     *           "end_address": "Sân bay quốc tế Tân Sơn Nhất, Đường Trường Sơn, Tân Bình, Hồ Chí Minh, Việt Nam",
     *           "created_at": "2024-08-22T14:21:17.000000Z",
     *           "updated_at": "2024-08-22T14:21:17.000000Z"
     *       }
     *   }
     *
     * @return JsonResponse
     */
    public function getRecentLocation(LocationRecentRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getRecentLocation($request);

            return $this->jsonResponseSuccess(new UserRecentLocationResource($response));
        } catch (Exception $e) {

            $this->logError('Get recent location failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Thông tin cấu hình tìm kiếm tài xế của khách hàng
     *
     * API lấy thông tin cấu hình user trả về các thông tin sau:
     * - Cước phí:
     *  + Thấp nhất: Lownest
     *  + Cao nhất: Highest
     * - Đời xe:
     *  + Mới nhất: Newest
     *  + Cũ nhất: Oldest
     * - Đánh giá theo số sao trung bình của tài xế:
     *  + Cao nhất: Highest
     *  + Thấp nhất: Lownest
     * - Giảm giá:
     *  + Nhiều nhất: Most
     *  + Ít nhất: Least
     * - Khoảng cách:
     *  + Gần nhất: Nearest
     *  + Xa nhất: Farest
     * - Loại xe:
     *  + C_Ride (2 chỗ) : MOTORCYCLE
     *  + C-Car (4 chỗ) : CAR_4
     *  + C-Car (7 chỗ) : CAR_7
     * - Thiết lập giá (price_setting_c_car): giá trị sẽ so sách với giá booking price của driver
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAv
     * Mjc5Mi1TRUUvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MjcwNjkyNDksImV4cCI6MTczMjI1MzI0OSwibmJmIjoxNzI3MDY5MjQ5LCJqdGkiOiJyZHQzY0JDRHNMRDlLbjBaIiwic3ViIjoiMTMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.LemR4j1dMWtfUuI4br1ZskKWIeDtaVcMefYmaCmWiHs
     * @response 200 {
     *       "status": 200,
     *       "message": "Thực hiện thành công.",
     *       "data": {
     *           "id": 13,
     *           "cost_preference": "Lowest",
     *           "rating_preference": "Highest",
     *           "discount_preference": "Most",
     *           "distance_preference": "Nearest",
     *           "vehicle_type": "MOTORCYCLE",
     *           "price_setting_c_car": 20000
     *       }
     *   }
     *
     * @return JsonResponse
     */
    public function configuration(): JsonResponse
    {
        try {
            $userId = $this->getCurrentUserId();
            $response = $this->repository->getConfiguration($userId);
            return $this->jsonResponseSuccess(new UserConfigurationResource($response));
        } catch (Exception $e) {

            $this->logError('Get configuration failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Lấy tất cả khách hàng
     *
     * API này cho phép lấy danh sách tất cả khách hàng trong hệ thống.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Lấy danh sách khách hàng thành công.",
     *     "data": [
     *         {
     *             "id": 1,
     *             "fullname": "John Doe",
     *             "email": "john.doe@example.com",
     *             "phone": "0961592551",
     *             "created_at": "2024-12-01T12:00:00Z",
     *             "updated_at": "2024-12-02T12:00:00Z"
     *         },
     *         {
     *             "id": 2,
     *             "fullname": "Jane Smith",
     *             "email": "jane.smith@example.com",
     *             "phone": "0961592552",
     *             "created_at": "2024-12-02T12:00:00Z",
     *             "updated_at": "2024-12-02T12:00:00Z"
     *         }
     *     ]
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Không thể lấy danh sách khách hàng do lỗi server."
     * }
     *
     * @param UserSearchRequest $request
     * @return JsonResponse
     */
    public function getAllUsers(UserSearchRequest $request): JsonResponse
    {
        try {
            $users = $this->repository->getAllUsers($request);
            return $this->jsonResponseSuccess(new UserAllResourceCollection($users));
        } catch (Throwable $e) {
            $this->logError('Get all users failed:', $e);
            return $this->jsonResponseError('Không thể lấy danh sách khách hàng do lỗi server.', 500);
        }
    }


}

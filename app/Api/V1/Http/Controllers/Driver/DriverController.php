<?php

namespace App\Api\V1\Http\Controllers\Driver;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Http\Requests\Driver\DriverConfigRequest;
use App\Api\V1\Http\Requests\Driver\DriverSearchRequest;
use App\Api\V1\Http\Requests\Driver\DriverUpdateRequest;
use App\Api\V1\Http\Resources\Driver\DriverConfigsResource;
use App\Api\V1\Http\Resources\Driver\DriverInfoResource;

use App\Api\V1\Http\Requests\Driver\DriverRequest;
use App\Api\V1\Http\Requests\Driver\DriverSearchRideCar;
use App\Api\V1\Http\Requests\Driver\DriverSearchIntercityRequest;

use App\Api\V1\Http\Resources\Driver\DriverSearchRideCarResource;
use App\Api\V1\Http\Resources\Driver\DriverSearchDeliveryResource;
use App\Api\V1\Http\Resources\Driver\DriverSearchMultiResource;
use App\Api\V1\Http\Resources\Driver\DriverSearchIntercityResource;



use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Driver\DriverServiceInterface;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;

use App\Enums\Vehicle\VehicleType;
use App\Enums\Order\OrderType;

use App\Traits\JwtService;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * @group Tài xế
 */
class DriverController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';


    protected UserRepositoryInterface $userRepository;
    protected RouteVariantRepositoryInterface $routerRepository;

    public function __construct(
        DriverServiceInterface $service,
        DriverRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        RouteVariantRepositoryInterface $routerRepository
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->routerRepository = $routerRepository;
        $this->middleware('auth:api', ['except' => ['login', 'search']]);
    }

    /**
     * Cập nhật tài xế
     *
     * API này dùng để cập nhật tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam avatar file optional Ảnh đại diện của tài xế. Example: avatar.jpg
     * @bodyParam id_card string optional Số CMND/CCCD của tài xế. Example: 123456789012
     * @bodyParam id_card_front file optional Ảnh mặt trước CMND/CCCD của tài xế. Example: id_card_front.jpg
     * @bodyParam id_card_back file optional Ảnh mặt sau CMND/CCCD của tài xế. Example: id_card_back.jpg
     * @bodyParam license_plate string optional Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam fullname string optional Họ và tên của tài xế. Example: Nguyễn Văn A
     * @bodyParam email string optional Email của tài xế. Example: example@example.com
     * @bodyParam phone string optional Số điện thoại của tài xế. Example: 0901234567
     * @bodyParam lat string optional Vĩ độ. Example: 10.762622
     * @bodyParam lng string optional Kinh độ. Example: 106.660172
     * @bodyParam address string optional Địa chỉ của tài xế. Example: 123 Đường ABC, Quận 1, TP.HCM
     * @bodyParam birthday string optional Ngày sinh của tài xế. Example: 1990-01-01
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
     * @bodyParam driver_license_front file optional Ảnh mặt trước giấy phép lái xe của tài xế. Example: driver_license_front.jpg
     * @bodyParam driver_license_back file optional Ảnh mặt sau giấy phép lái xe của tài xế. Example: driver_license_back.jpg
     * @bodyParam bank_name string optional Tên ngân hàng. Example: Vietcombank
     * @bodyParam bank_account_name string optional Tên tài khoản ngân hàng. Example: Nguyễn Văn A
     * @bodyParam bank_account_number string optional Số tài khoản ngân hàng. Example: 0123456789
     * @bodyParam current_address string optional Địa chỉ hiện tại. Example: 456 Đường XYZ, Quận 2, TP.HCM
     * @bodyParam current_lat string optional Vĩ độ hiện tại. Example: 10.762622
     * @bodyParam current_lng string optional Kinh độ hiện tại. Example: 106.660172
     * @bodyParam auto_accept boolean optional Tự động chấp nhận chuyến đi (Tự động: 1, Tắt: 2, Khoá: 3). Example: 1
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string optional Tên xe. Example: Vios
     * @bodyParam price integer optional Giá thuê. Example: 500000
     * @bodyParam vehicle_registration_front file optional Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file optional Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam vehicle_front_image file optional Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file optional Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file optional Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file optional Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * @bodyParam insurance_front_image file optional Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file optional Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
     * @bodyParam color string optional Màu xe. Example: Đen
     * @bodyParam seat_number integer optional Số ghế. Example: 4
     * @bodyParam type string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @bodyParam vehicle_line_id string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     *
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
    public function update(DriverUpdateRequest $request): JsonResponse
    {
        try {
            $this->service->update($request);
            return $this->jsonResponseSuccess(null, '', 200);
        } catch (Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Đăng ký
     *
     * API này dùng để đăng ký thông tin cho tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam emergency_contact_name string required Tên người liên hệ khẩn cấp. Example: Nguyễn Văn A
     * @bodyParam emergency_contact_address string required Địa chỉ người liên hệ khẩn cấp. Example: 123 Đường ABC, Quận 1, TP.HCM
     * @bodyParam emergency_contact_phone string required Số điện thoại người liên hệ khẩn cấp. Example: 0912345678
     * @bodyParam avatar file optional Ảnh đại diện của tài xế. Example: avatar.jpg
     * @bodyParam id_card string required Số CMND/CCCD của tài xế. Example: 123456789012
     * @bodyParam id_card_front file required Ảnh mặt trước CMND/CCCD của tài xế. Example: id_card_front.jpg
     * @bodyParam id_card_back file required Ảnh mặt sau CMND/CCCD của tài xế. Example: id_card_back.jpg
     * @bodyParam license_plate string required Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
     * @bodyParam driver_license_front file required Ảnh mặt trước giấy phép lái xe của tài xế. Example: driver_license_front.jpg
     * @bodyParam driver_license_back file required Ảnh mặt sau giấy phép lái xe của tài xế. Example: driver_license_back.jpg
     * @bodyParam auto_accept boolean optional Tự động chấp nhận chuyến đi (Tự động: 1, Tắt: 2, Khoá: 3). Example: 1
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string required Tên xe. Example: Vios
     * @bodyParam price integer required Giá thuê. Example: 500000
     * @bodyParam vehicle_registration_front file required Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file required Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam vehicle_front_image file required Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file required Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file required Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file required Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * @bodyParam insurance_front_image file required Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file required Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
     * @bodyParam color string required Màu xe. Example: Đen
     * @bodyParam seat_number integer required Số ghế. Example: 4
     * @bodyParam type string optional Loại xe (Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @bodyParam vehicle_line_id string required Loại xe. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Kiểm tra lại các trường."
     * }
     *
     * @response 422 {
     *     "status": 422,
     *     "error": "Registration failed."
     * }
     *
     * @return JsonResponse
     */
    public function register(DriverRequest $request): JsonResponse
    {

        try {
            $response = $this->service->store($request);
            return $this->jsonResponseSuccess($response);
        } catch (BadRequestException $e) {
            $this->logError('Driver creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 400);
        } catch (Throwable $e) {
            $this->logError('Driver creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Lấy cấu hình tài xế
     *
     * API này dùng để lấy thông tin cấu hình của tài xế
     *
     * Trạng thái của các dịch vụ:
     * - 1: Bật dịch vụ
     * - 2: Tắt dịch vụ
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "service_ride": 2,
     *         "service_ride_price": "12000",
     *         "service_car": 2,
     *         "service_car_price": "20000",
     *         "service_delivery_now": 2,
     *         "service_delivery_now_price": "15000",
     *         "service_delivery_later": 2,
     *         "delivery_later_fee_per_stop": "4000",
     *         "service_intercity": 2,
     *         "service_intercity_price": "8000",
     *         "peak_hour_price": "7000",
     *         "night_time_price": "8000",
     *         "holiday_price": "12000",
     *         "weight_ranges": [
     *             {
     *                 "id": 10,
     *                 "min_weight": "20",
     *                 "max_weight": "25",
     *                 "price": "60000"
     *             },
     *             {
     *                 "id": 9,
     *                 "min_weight": "15",
     *                 "max_weight": "20",
     *                 "price": "50000"
     *             },
     *             {
     *                 "id": 8,
     *                 "min_weight": "10",
     *                 "max_weight": "15",
     *                 "price": "0"
     *             },
     *             {
     *                 "id": 7,
     *                 "min_weight": "5",
     *                 "max_weight": "10",
     *                 "price": "0"
     *             },
     *             {
     *                 "id": 6,
     *                 "min_weight": "0",
     *                 "max_weight": "5",
     *                 "price": "0"
     *             }
     *         ]
     *     }
     * }
     *
     * @return JsonResponse
     */
    public function getDriverConfigs(): JsonResponse
    {
        try {
            $response = $this->service->getDriver();
            return $this->jsonResponseSuccess(new DriverConfigsResource($response));
        } catch (Throwable $e) {
            $this->logError('Driver config failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Cập nhật cấu hình tài xế
     *
     * API này dùng để cập nhật thông tin cấu hình của tài xế
     *
     * Trạng thái của các dịch vụ:
     * - 1: Bật dịch vụ
     * - 2: Tắt dịch vụ
     *
     * @authenticated
     *
     * @bodyParam service_ride integer required Dịch vụ C_RIDE. Example: 2
     * @bodyParam service_ride_price string Giá dịch vụ C_RIDE. Example: 12000
     * @bodyParam service_car integer required Dịch vụ C_CAR. Example: 2
     * @bodyParam service_car_price string Giá dịch vụ C_CAR. Example: 20000
     * @bodyParam service_delivery_now integer required Dịch vụ C_DELIVERY. Example: 2
     * @bodyParam service_delivery_now_price string Giá dịch vụ C_DELIVERY. Example: 15000
     * @bodyParam service_delivery_later integer required Dịch vụ C_Multi. Example: 2
     * @bodyParam delivery_later_fee_per_stop string Phí dịch vụ C_Multi trên mỗi điểm dừng. Example: 4000
     * @bodyParam service_intercity integer required Dịch vụ C_INTERCITY. Example: 2
     * @bodyParam service_intercity_price string Giá dịch vụ C_INTERCITY. Example: 8000
     * @bodyParam service_intercity_start_time string Thời gian bắt đầu dịch vụ C_INTERCITY. Example: 08:00
     * @bodyParam service_intercity_end_time string Thời gian kết thúc dịch vụ C_INTERCITY. Example: 18:00
     * @bodyParam peak_hour_price string Giá giờ cao điểm. Example: 7000
     * @bodyParam night_time_price string Giá giờ đêm. Example: 8000
     * @bodyParam holiday_price string Giá ngày lễ. Example: 12000
     * @bodyParam weight_ranges array Mảng giá trị trọng lượng. Example: [{"id": 10,"price": "60000"}]
     * @bodyParam active string required Trạng thái hoạt động. Example: ON
     * @bodyParam auto_accept integer required Tự động chấp nhận chuyến đi. Example: 1
     *
     * @response 200 {
     *    "status": 200,
     *   "message": "Thực hiện thành công."
     * }
     *
     * @response 500 {
     *    "status": 500,
     *   "message": "Error."
     * }
     *
     * @return JsonResponse
     */

    public function updateDriverConfigs(DriverConfigRequest $request): JsonResponse
    {
        try {
            $this->service->updateDriverConfigs($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Throwable $e) {
            $this->logError('Driver config failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Lấy thông tin tài xế
     *
     * API này dùng để lấy thông tin của tài xế
     *
     * @authenticated
     *
     * @bodyParam driver_id string required ID của tài xế. Example: 1
     * @body distance string nullable Khoảng cách. Example: 10
     * @body order_type string nullable Loại đơn hàng. Example: C_RIDE
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "id": 1,
     *         "user": {
     *             "name": "NGUYỄN MINH HUY",
     *             "image": "/public/uploads/images/drivers/PSOB6B3wVnItL945mAi3Zww6hUqYaUNkDfW9jm05.jpg"
     *         },
     *         "booking_price": 8000,
     *         "reviews": {
     *             "total": 3,
     *             "avg": 3.7
     *         },
     *         "vehicle": {
     *             "name": "SH",
     *             "license_plate": "222221"
     *         }
     *     }
     * }
     *
     * @response 500 {
     *   "status": 500,
     *  "message": "Error."
     * }
     *
     * @return JsonResponse
     */

    public function getDriverInfo(DriverConfigRequest $request): JsonResponse
    {
        try {
            $response = $this->service->getDriverInfo($request);
            return $this->jsonResponseSuccess(new DriverInfoResource($response));
        } catch (Throwable $e) {
            $this->logError('Driver config failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }



    /**
      * Tìm kiếm tài xế C_RIDE/CAR
      *
      * API này dùng để tìm kiếm tài xế theo các tiêu chí:
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
      * - Thiết lập giá: nhập vào mức giá tìm kiếm, giá trị sẽ so sách với giá booking price của driver
      * - Loại đơn hàng:
      *  + C_RIDE: Đơn hàng đặt xe (Ride)
      *  + C_CAR: Đơn hàng đặt xe (Car)
      *  + C_Intercity: Đơn hàng liên tỉnh
      *  + C_Delivery: Đơn hàng giao hàng
      *  + C_Multi: Đơn hàng đa điểm

      * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
      * @authenticated

      * @bodyParam cost_preference string Cước phí. Example: Lowest
      * @bodyParam distance string Khoảng cách Example: Nearest
      * @bodyParam start_latitude integer required Vĩ độ bắt đầu . Example: 10.8275553
      * @bodyParam start_longitude integer required Kinh độ bắt đầu . Example: 106.7214274
      * @bodyParam end_lat float required Vĩ độ điểm kết thúc. Example: 10.815832
      * @bodyParam end_lng float required Kinh độ điểm kết thúc. Example: 106.664132
      * @bodyParam vehicles string nullable Đời xe. Example: Newest
      * @bodyParam review string nullable Đánh giá. Example: Highest
      * @bodyParam discount string nullable Giảm giá. Example: Most
      * @bodyParam type string nullable Loại xe. Example: MOTORCYCLE
      * @bodyParam price_setting integer nullable Thiết lập giá. Example: 19000
      * @bodyParam order_type string required Loại đơn hàng. Example: C_CAR
      *
      * @response 200 {
      *      "status": 200,
      *      "message": "Thực hiện thành công.",
      *      "data": {
      *         "drivers": [
      *         {
      *             "driver_id": 6,
      *             "current_lat": 10.815832,
      *             "current_lng": 106.664132,
      *             "address": null,
      *             "driver_name": "Trần Trọng Phụng",
      *             "vehicle": {
      *                 "id": 8,
      *                 "status": 2,
      *                 "name": "Xe Dream",
      *                 "type": "MOTORCYCLE",
      *                 "license_plate": "212398",
      *                 "production_year": 0
      *             },
      *             "price_setting_service": 63919,
      *             "active_discount_count": 10,
      *             "distance": 6.4,
      *             "price_for_distance": 63919.9,
      *             "rating": 0,
      *             "reviews_count": 0,
      *         }
      *      }
      * }
      *
      * @response 404 {
      *     "status": 404,
      *     "message": "Không tìm thấy tài xế."
      * }
      *
      * @return JsonResponse
      */

    public function searchRideCar(DriverSearchRideCar $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->repository->searchRideCar($data);
            $priceSetting = (float) ($data['price_setting'] ?? null);
            $orderType = $data['order_type'] ?? null;
            $filteredDrivers = $response->filter(function ($driver) use ($data) {
                Log::info('mess', ['mess' => $driver]);
                switch ($data['order_type']) {
                    case OrderType::C_RIDE->value:
                        $price_setting_service = $driver->service_ride_price * $driver->calculateDistanceUsingGoogleAPI;
                        break;
                    case OrderType::C_CAR->value:
                        $price_setting_service = $driver->service_car_price * $driver->calculateDistanceUsingGoogleAPI;
                        break;
                    case OrderType::C_Intercity->value:
                        $price_setting_service = $driver->service_intercity_price * $driver->calculateDistanceUsingGoogleAPI;
                        break;
                    case OrderType::C_Delivery->value:
                        $price_setting_service = $driver->service_delivery_now_price * $driver->calculateDistanceUsingGoogleAPI;
                        break;
                    case OrderType::C_Multi->value:
                        $price_setting_service = $driver->delivery_later_fee_per_stop * $driver->calculateDistanceUsingGoogleAPI;
                        break;
                    default:
                        $price_setting_service = 0;
                }
                $driver->price_setting_service = $price_setting_service;

                return $price_setting_service > 0;
            });

            $exactPriceDrivers = $filteredDrivers->filter(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            });

            $remainingDrivers = $filteredDrivers->reject(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            })->sortBy('price_setting_service');

            $sortedDrivers = $exactPriceDrivers->merge($remainingDrivers);

            return $this->jsonResponseSuccess(new DriverSearchRideCarResource($sortedDrivers, $orderType));

        } catch (Throwable $e) {
            $this->logError('Driver search failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }


    /**
      * Tìm kiếm tài xế C_Delivery
      *
      * API này dùng để tìm kiếm tài xế theo các tiêu chí:
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
      * - Loại đơn hàng:
      *  + C_RIDE: Đơn hàng đặt xe (Ride)
      *  + C_CAR: Đơn hàng đặt xe (Car)
      *  + C_Intercity: Đơn hàng liên tỉnh
      *  + C_Delivery: Đơn hàng giao hàng
      *  + C_Multi: Đơn hàng đa điểm

      * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvM
      * @authenticated

      * @bodyParam cost_preference string Tùy chọn cước phí. Có thể là "Lowest" hoặc "Highest". Example: Lowest
      * @bodyParam start_latitude float required Vĩ độ bắt đầu. Example: 10.8275553
      * @bodyParam start_longitude float required Kinh độ bắt đầu. Example: 106.7214274
      * @bodyParam end_lat float required Vĩ độ điểm kết thúc. Example: 10.815832
      * @bodyParam end_lng float required Kinh độ điểm kết thúc. Example: 106.664132
      * @bodyParam vehicles string nullable Tùy chọn về đời xe. Có thể là "Newest" hoặc "Oldest". Example: Newest
      * @bodyParam review string nullable Tùy chọn đánh giá. Có thể là "Highest" hoặc "Lowest". Example: Highest
      * @bodyParam discount string nullable Tùy chọn giảm giá. Có thể là "Most" hoặc "Least". Example: Most
      * @bodyParam price_setting float nullable Mức giá mong muốn cho chuyến đi. Example: 65000
      *
      * @response 200 {
      *      "status": 200,
      *      "message": "Thực hiện thành công.",
      *      "data": {
      *         "drivers": [
      *         {
      *             "driver_id": 6,
      *             "current_lat": 10.815832,
      *             "current_lng": 106.664132,
      *             "address": null,
      *             "driver_name": "Trần Trọng Phụng",
      *             "vehicle": {
      *                 "id": 8,
      *                 "status": 2,
      *                 "name": "Xe Dream",
      *                 "type": "MOTORCYCLE",
      *                 "license_plate": "212398",
      *                 "production_year": 0
      *             },
      *             "price_setting_service": 63919,
      *             "active_discount_count": 10,
      *             "distance": 6.4,
      *             "price_for_distance": 63919.9,
      *             "rating": 0,
      *             "reviews_count": 0,
      *         }
      *      }
      * }
      *
      * @response 404 {
      *     "status": 404,
      *     "message": "Không tìm thấy tài xế."
      * }
      *
      * @return JsonResponse
      */

    public function searchDelivery(DriverSearchRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->repository->searchByDeliveryAndMulti($data);

            $orderType = $data['order_type'] ?? null;
            $priceSetting = (float) ($data['price_setting'] ?? null);
            $filteredDrivers = $response->filter(function ($driver) use ($data) {

                $price_setting_service = $driver->service_delivery_now_price * $driver->calculateDistanceUsingGoogleAPI;

                $driver->price_setting_service = $price_setting_service;

                return $price_setting_service > 0;

            });

            $exactPriceDrivers = $filteredDrivers->filter(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            });
            $remainingDrivers = $filteredDrivers->reject(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            })->sortBy('price_setting_service');

            $sortedDrivers = $exactPriceDrivers->merge($remainingDrivers);

            return $this->jsonResponseSuccess(new DriverSearchDeliveryResource($sortedDrivers, $orderType));
        } catch (Throwable $e) {
            $this->logError('Driver search failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
      * Tìm kiếm tài xế C_Multi
      *
      * API này dùng để tìm kiếm tài xế theo các tiêu chí:
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
      * - Loại đơn hàng:
      *  + C_RIDE: Đơn hàng đặt xe (Ride)
      *  + C_CAR: Đơn hàng đặt xe (Car)
      *  + C_Intercity: Đơn hàng liên tỉnh
      *  + C_Delivery: Đơn hàng giao hàng
      *  + C_Multi: Đơn hàng đa điểm

      * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvM
      * @authenticated

      * @bodyParam cost_preference string Tùy chọn cước phí. Có thể là "Lowest" hoặc "Highest". Example: Lowest
      * @bodyParam start_latitude float required Vĩ độ bắt đầu. Example: 10.8275553
      * @bodyParam start_longitude float required Kinh độ bắt đầu. Example: 106.7214274
      * @bodyParam end_lat float required Vĩ độ điểm kết thúc. Example: 10.815832
      * @bodyParam end_lng float required Kinh độ điểm kết thúc. Example: 106.664132
      * @bodyParam vehicles string nullable Tùy chọn về đời xe. Có thể là "Newest" hoặc "Oldest". Example: Newest
      * @bodyParam review string nullable Tùy chọn đánh giá. Có thể là "Highest" hoặc "Lowest". Example: Highest
      * @bodyParam discount string nullable Tùy chọn giảm giá. Có thể là "Most" hoặc "Least". Example: Most
      * @bodyParam price_setting float nullable Mức giá mong muốn cho chuyến đi. Example: 65000
      *
      * @response 200 {
      *      "status": 200,
      *      "message": "Thực hiện thành công.",
      *      "data": {
      *         "drivers": [
      *         {
      *             "driver_id": 6,
      *             "current_lat": 10.815832,
      *             "current_lng": 106.664132,
      *             "address": null,
      *             "driver_name": "Trần Trọng Phụng",
      *             "vehicle": {
      *                 "id": 8,
      *                 "status": 2,
      *                 "name": "Xe Dream",
      *                 "type": "MOTORCYCLE",
      *                 "license_plate": "212398",
      *                 "production_year": 0
      *             },
      *             "price_setting_service": 63919,
      *             "active_discount_count": 10,
      *             "distance": 6.4,
      *             "price_for_distance": 63919.9,
      *             "rating": 0,
      *             "reviews_count": 0,
      *         }
      *      }
      * }
      *
      * @response 404 {
      *     "status": 404,
      *     "message": "Không tìm thấy tài xế."
      * }
      *
      * @return JsonResponse
      */

    public function searchMulti(DriverSearchRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->repository->searchByDeliveryAndMulti($data);

            $orderType = $data['order_type'] ?? null;
            $priceSetting = (float) ($data['price_setting'] ?? null);

            $filteredDrivers = $response->filter(function ($driver) use ($data) {

                $price_setting_service = $driver->delivery_later_fee_per_stop * $driver->calculateDistanceUsingGoogleAPI;

                $driver->price_setting_service = $price_setting_service;

                return $price_setting_service > 0;
            });

            $exactPriceDrivers = $filteredDrivers->filter(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            });
            $remainingDrivers = $filteredDrivers->reject(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            })->sortBy('price_setting_service');

            $sortedDrivers = $exactPriceDrivers->merge($remainingDrivers);

            return $this->jsonResponseSuccess(new DriverSearchMultiResource($sortedDrivers, $orderType));
        } catch (Throwable $e) {
            $this->logError('Driver search failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }


    /**
     * Tìm kiếm tài xế C_Intercity
     *
     * API này dùng để tìm kiếm tài xế theo các tiêu chí:
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
     * - Dòng xe:
     *  + CAR_4: 4 chỗ
     *  + CAR_7: 7 chỗ
     * - Loại đơn hàng:
     *  + C_RIDE: Đơn hàng đặt xe (Ride)
     *  + C_CAR: Đơn hàng đặt xe (Car)
     *  + C_Intercity: Đơn hàng liên tỉnh
     *  + C_Delivery: Đơn hàng giao hàng
     *  + C_Multi: Đơn hàng đa điểm
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvM
     * @authenticated
     * @bodyParam cost_preference string Tùy chọn cước phí. Có thể là "Lowest" hoặc "Highest". Example: Lowest
     * @bodyParam start_latitude float required Vĩ độ điểm bắt đầu. Example: 10.8275553
     * @bodyParam start_longitude float required Kinh độ điểm bắt đầu. Example: 106.664132
     * @bodyParam end_lat float required Vĩ độ điểm kết thúc. Example: 10.815832
     * @bodyParam end_lng float required Kinh độ điểm kết thúc. Example: 106.664132
     * @bodyParam vehicles string nullable Tùy chọn về đời xe. Có thể là "Newest" hoặc "Oldest". Example: Newest
     * @bodyParam review string nullable Tùy chọn đánh giá. Có thể là "Highest" hoặc "Lowest". Example: Highest
     * @bodyParam discount string nullable Tùy chọn giảm giá. Có thể là "Most" hoặc "Least". Example: Most
     * @bodyParam price_setting float nullable Mức giá mong muốn cho chuyến đi. Example: 65000
     * @bodyParam type string nullable Loại xe. Example: CAR_4
     * @bodyParam passenger_count integer required Số lượng khách. Example: 4
     * @bodyParam route_variant_id integer required ID tuyến đường. Example: 4
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *         "drivers": [
     *         {
     *             "driver_id": 6,
     *             "current_lat": 10.815832,
     *             "current_lng": 106.664132,
     *             "address": null,
     *             "driver_name": "Trần Trọng Phụng",
     *             "vehicle": {
     *                 "id": 8,
     *                 "status": 2,
     *                 "name": "Xe Dream",
     *                 "type": "MOTORCYCLE",
     *                 "license_plate": "212398",
     *                 "production_year": 0
     *             },
     *             "price_setting_service": 63919,
     *             "active_discount_count": 10,
     *             "distance": 6.4,
     *             "price_for_distance": 63919.9,
     *             "rating": 0,
     *             "reviews_count": 0,
     *         }
     *      }
     * }
     *
     * @response 404 {
     *     "status": 404,
     *     "message": "Không tìm thấy tài xế."
     * }
     *
     * @param DriverSearchIntercityRequest $request
     * @return JsonResponse
     */

    public function searchIntercity(DriverSearchIntercityRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->repository->searchIntercity($data);
            $priceSetting = (float) ($data['price_setting'] ?? null);
            $orderType = $data['order_type'] ?? null;
            $routerVariant = $this->routerRepository->find($data['route_variant_id']);

            $serviceIntercityPrice = $routerVariant->price * $data['passenger_count'];

            $filteredDrivers = $response->filter(function ($driver) use ($serviceIntercityPrice) {

                $driver->price_setting_service = $serviceIntercityPrice;
                ;

                return $driver->price_setting_service > 0;
            });

            $exactPriceDrivers = $filteredDrivers->filter(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            });
            $remainingDrivers = $filteredDrivers->reject(function ($driver) use ($priceSetting) {
                return $driver->price_setting_service == $priceSetting;
            })->sortBy('price_setting_service');

            $sortedDrivers = $exactPriceDrivers->merge($remainingDrivers);

            return $this->jsonResponseSuccess(new DriverSearchIntercityResource($sortedDrivers, $orderType));

        } catch (Throwable $e) {
            $this->logError('Driver search failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
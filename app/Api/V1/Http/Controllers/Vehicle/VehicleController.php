<?php

namespace App\Api\V1\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Vehicle\{VehicleRequest,VehicleStoreRequest};
use App\Api\V1\Http\Resources\Vehicle\{VehicleResource,DriverVehicleResource};
use App\Api\V1\Validate\Validator;
use App\Api\V1\Services\Vehicle\VehicleServiceInterface;
use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Traits\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

/**
 * @group Phương tiện
 */
class VehicleController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        VehicleRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        VehicleServiceInterface    $service
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->middleware('auth:api');
    }

    protected function resolve(): bool
    {
        $user = $this->userRepository->findByField('phone', $this->login['phone']);
        if ($user) {
            Auth::login($user);
            return true;
        }
        return false;
    }

    /**
     * Lấy thông tin chi tiết xe
     *
     * Các loại (type) của xe bao gồm:
     * - 1: Chưa được phân loại
     * - 2: Gắn máy
     * - 3: Xe ô tô
     * - 4: Xe tải
     * - 5: Xe tải đông lạnh
     *
     * Các trạng thái (status) của xe bao gồm:
     * - 1: Chờ xác nhận
     * - 2: Đã thuê
     * - 3: Không hoạt động
     * - 4: Đang sửa chữa
     *
     * API này trả về thông tin chi tiết xe
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @pathParam id int required ID của phương tiện. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 1,
     *          "driver_id": 5,
     *          "name": "Toyota",
     *          "color": "Xanh dương",
     *          "type": 3,
     *          "seat_number": 7,
     *          "license_plate": "11111",
     *          "license_plate_image": "public/uploads/images/drivers//h2vUHlF0HsnFVmN5LssabTr1GgWCw9GSuhwFG5c6.jpg",
     *          "vehicle_company": "Audi",
     *          "vehicle_registration_front": "/public/assets/images/default-image.png",
     *          "vehicle_registration_back": "/public/assets/images/default-image.png",
     *          "vehicle_front_image": null,
     *          "vehicle_back_image": null,
     *          "vehicle_side_image": null,
     *          "vehicle_interior_image": null,
     *          "insurance_front_image": null,
     *          "insurance_back_image": null,
     *          "amenities": "Tiện ích",
     *          "description": "Mô tả",
     *          "created_at": "2024-07-18T09:28:57.000000Z",
     *          "updated_at": "2024-07-18T09:28:57.000000Z",
     *          "price": 999999
     *      }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {   
        try {
            Validator::validateExists($this->repository, $id);
            $response = $this->repository->findOrFail($id);
            return $this->jsonResponseSuccess(new VehicleResource($response));
        } catch (Exception $e) {
            return $this->jsonResponseError('Get detail Vehicle error');
        }
    }

     /**
     *Thêm phương tiện cho tài xế
     *
     * API này dùng để thêm phương tiện cho tài xế
    
     *
     * @bodyParam avatar file optional Ảnh đại diện của phương tiện. Example: avatar.jpg
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string optional Tên xe. Example: Vios 
     * @bodyParam vehicle_registration_front file optional Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file optional Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam production_year integer required Năm sản xuất. Example: 2018
     * @bodyParam seat_number integer optional Số ghế. Example: 4
     * @bodyParam vehicle_front_image file optional Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file optional Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file optional Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file optional Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * 
     * @bodyParam license_plate string optional Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
    
     * @bodyParam insurance_front_image file optional Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file optional Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
  
     * @bodyParam type string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @bodyParam vehicle_line_id string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     *      "data": {
     *          "id": 1,
     *          "fullname": Tài xế,
     *          "name": "Toyota",
     *          "color": "Xanh dương",
     *          "type": 3,
     *          "seat_number": 7,
     *          "license_plate": "11111",
     *          "license_plate_image": "public/uploads/images/drivers//h2vUHlF0HsnFVmN5LssabTr1GgWCw9GSuhwFG5c6.jpg",
     *          "vehicle_company": "Audi",
     *          "vehicle_registration_front": "/public/assets/images/default-image.png",
     *          "vehicle_registration_back": "/public/assets/images/default-image.png",
     *          "vehicle_front_image": null,
     *          "vehicle_back_image": null,
     *          "vehicle_side_image": null,
     *          "vehicle_interior_image": null,
     *          "insurance_front_image": null,
     *          "insurance_back_image": null,
     *          "amenities": "Tiện ích",
     *          "description": "Mô tả",
     *          "created_at": "2024-07-18T09:28:57.000000Z",
     *          "updated_at": "2024-07-18T09:28:57.000000Z",
     *          "price": 999999
     *      }
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
    public function store(VehicleStoreRequest $request): JsonResponse
    {
        try {
            $vehicle = $this->service->store($request);
            return $this->jsonResponseSuccess(new VehicleResource($vehicle));
        } catch (Exception $e) {
            $this->logError('Vehicle creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }

    /**
     * Sửa phương tiện
     *
     * API này dùng để Sửa phương tiện cho tài xế
     * 
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @bodyParam avatar file optional Ảnh đại diện của phương tiện. Example: avatar.jpg
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string optional Tên xe. Example: Vios 
     * @bodyParam vehicle_registration_front file optional Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file optional Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam production_year integer required Năm sản xuất. Example: 2018
     * @bodyParam seat_number integer optional Số ghế. Example: 4
     * @bodyParam vehicle_front_image file optional Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file optional Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file optional Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file optional Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * 
     * @bodyParam license_plate string optional Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
    
     * @bodyParam insurance_front_image file optional Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file optional Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
  
     * @bodyParam type string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @bodyParam vehicle_line_id string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *          "id": 1,
     *          "fullname": Tài xế,
     *          "name": "Toyota",
     *          "color": "Xanh dương",
     *          "type": 3,
     *          "seat_number": 7,
     *          "license_plate": "11111",
     *          "license_plate_image": "public/uploads/images/drivers//h2vUHlF0HsnFVmN5LssabTr1GgWCw9GSuhwFG5c6.jpg",
     *          "vehicle_company": "Audi",
     *          "vehicle_registration_front": "/public/assets/images/default-image.png",
     *          "vehicle_registration_back": "/public/assets/images/default-image.png",
     *          "vehicle_front_image": null,
     *          "vehicle_back_image": null,
     *          "vehicle_side_image": null,
     *          "vehicle_interior_image": null,
     *          "insurance_front_image": null,
     *          "insurance_back_image": null,
     *          "amenities": "Tiện ích",
     *          "description": "Mô tả",
     *          "created_at": "2024-07-18T09:28:57.000000Z",
     *          "updated_at": "2024-07-18T09:28:57.000000Z",
     *          "price": 999999
     *      }
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
    public function update(VehicleRequest $request): JsonResponse
    {
        try {
            $response = $this->service->update($request);
            return $this->jsonResponseSuccess(new VehicleResource($response));
        } catch (Exception $e) {
            $this->logError('Vehicle creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }

     /**
     *Danh sách phương tiện
     *
     * API này dùng để lấy danh sách phương tiện theo tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam avatar file optional Ảnh đại diện của phương tiện. Example: avatar.jpg
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string optional Tên xe. Example: Vios 
     * @bodyParam vehicle_registration_front file optional Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file optional Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam production_year integer required Năm sản xuất. Example: 2018
     * @bodyParam seat_number integer optional Số ghế. Example: 4
     * @bodyParam vehicle_front_image file optional Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file optional Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file optional Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file optional Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * 
     * @bodyParam license_plate string optional Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
    
     * @bodyParam insurance_front_image file optional Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file optional Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
  
     * @bodyParam type string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * @bodyParam vehicle_line_id string optional Loại xe(Xe 2 bánh, xe 4 bánh). Example: CAR
     * 
     * @bodyParam emergency_contact_name string required Tên người liên hệ khẩn cấp. Example: Nguyễn Văn A
     * @bodyParam emergency_contact_phore string required Số điện thoại người liên hệ khẩn cấp. Example: 0379 991 281
     * @bodyParam emergency_contact_address string required Địa chỉ người liên hệ khẩn cấp. Example: 123 Đường ABC, Quận 1, TP.HCM
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *           "id": 6,
     *           "fullname": "Tài xế",
     *           "name": "Honda Wave S100",
     *           "color": "7 màu",
     *           "type": "CAR_7",
     *           "seat_number": null,
     *           "license_plate": "ABCD-1800",
     *           "license_plate_image": "public/uploads/images/vehicles//y8oObSCai3o0BjGKSXKY78BsmP5OWQMEHzRz1OOw.jpg",
     *           "vehicle_company": null,
     *           "vehicle_registration_front": null,
     *           "vehicle_registration_back": null,
     *           "vehicle_front_image": null,
     *           "vehicle_back_image": null,
     *           "vehicle_side_image": null,
     *           "vehicle_interior_image": null,
     *           "insurance_front_image": null,
     *           "insurance_back_image": null,
     *           "amenities": null,
     *           "description": null,
     *           "created_at": "2024-09-30",
     *           "updated_at": "2024-09-30",
     *           "price": null,
     *           "status": null
     *     }
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
    public function view(): JsonResponse
    {
        try {
            $driverId = $this->getCurrentDriverId();
            $vehicle = $this->repository->getVehicleByDriver($driverId);
            return $this->jsonResponseSuccess(DriverVehicleResource::collection($vehicle));
        } catch (Exception $e) {
            $this->logError('Vehicle show by Driver failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }

}

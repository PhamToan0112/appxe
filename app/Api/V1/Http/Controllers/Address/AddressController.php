<?php

namespace App\Api\V1\Http\Controllers\Address;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Address\AddressRequest;
use App\Api\V1\Services\Address\AddressServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Support\Facades\log;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use App\Api\V1\Http\Resources\Address\AddressResource;
use App\Api\V1\Repositories\Address\AddressRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;

/**
 * @group Địa chỉ
 */
class   AddressController extends Controller
{
    use Response, UseLog, AuthServiceApi;

    protected $service;
    protected $repository;

    public function __construct(
        AddressServiceInterface    $service,
        AddressRepositoryInterface $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Danh sách địa chỉ
     *
     * Lấy danh sách địa chỉ theo userId
     *
     * Loại địa chỉ (type): gồm 4 trạng thái
     * - home: nhà riêng (mặc định)
     * - work : cơ quan
     * - school : trường học
     * - other : khác
     *
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *              "fullname": "Tran Van A",
     *              "address": "Địa chỉ 1",
     *              "latitude": 10.7725168,
     *              "longitude": 106.6980208,
     *              "type": "home"
     *          }
     *      ]
     * }
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $userId = $this->getCurrentUserId();
            $addresses = $this->repository->getByUserId($userId);

            return $this->jsonResponseSuccess(AddressResource::collection($addresses));
        } catch (Exception $e) {
            $this->logError('Fetching addresses failed:', $e);
            return $this->jsonResponseError('Fetching addresses failed', 500);
        }
    }

    /**
     * Tạo địa chỉ
     *
     * Tạo địa chỉ theo user_id.
     * 
     * Loại địa chỉ (type): gồm 4 trạng thái
     * - home: nhà riêng (mặc định)
     * - work : cơ quan
     * - school : trường học
     * - other : khác
     * 
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated
     * @bodyParam address string Địa chỉ của user_id. Example: Công Viên Sala, 01 Hoàng Thế Thiện, An Lợi Đông, Thành Phố Thủ Đức, Hồ Chí Minh 700000, Việt Nam
     * @bodyParam latitude integer Vĩ độ. Example: 10.7721778000
     * @bodyParam longitude integer Kinh độ. Example: 106.7246327000
     * @bodyParam name string Tên gợi ý. Example: name
     * @bodyParam type string Loại địa chỉ. Example: home
     * @bodyParam default string Mặc định. Example: default
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 10,
     *          "fullname": "Tran Van A",
     *          "name": "name",
     *          "address": "Công Viên Sala, 01 Hoàng Thế Thiện, An Lợi Đông, Thành Phố Thủ Đức, Hồ Chí Minh 700000, Việt Nam",
     *          "latitude": 10.7721778000,
     *          "longitude": 106.7246327000,
     *          "type": "home",
     *          "default": "default"
     *      }
     * }
     *
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function store(AddressRequest $request): JsonResponse
    {
        try {
            $address = $this->service->store($request);
            return $this->jsonResponseSuccess(new AddressResource($address));
        } catch (Exception $e) {
            $this->logError('Address creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }


    /**
     * Xoá Địa chỉ
     *
     * API này dùng để Xoá Địa chỉ
     * @authenticated
     * Example: Bearer
     * eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @pathParam id int required ID của Địa chỉ cần xoá. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $address = $this->repository->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to delete address', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Cập nhật Địa chỉ
     *
     * API này dùng để Cập nhật: 
     * 
     * - Tên địa chỉ gợi ý (name)
     * - Địa chỉ (address)
     * - Kinh độ (longitude)
     * - Vĩ độ (latitude)
     * - Loại địa chỉ (type): gồm 4 trạng thái
     * + home: nhà riêng (mặc định)
     * + work : cơ quan
     * + school : trường học
     * + other : khác
     * - Trạng thái mặc định:
     * + default : mặc định (nhà riêng)
     * + not_default: không mặc định
     * 
     * @authenticated
     * Example: Bearer
     * eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam address string required Tên của Địa chỉ cần cập nhật. Example: Địa chỉ update ở đây
     * @bodyParam longitude integer required Kinh độ. Example: 106.6641318
     * @bodyParam latitude integer required Vĩ độ. Example: 10.8158321
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *          "id": 1,
     *          "fullname": "User 1",
     *          "address": "Địa chỉ 1",
     *          "latitude": 106.6641318,
     *          "longitude": 10.8158321,
     *          "type": "home",
     *          "name": "Địa chỉ gợi ý",
     *          "default_status": "not_default"
     *      }
     * }
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function update(AddressRequest $request,$id):JsonResponse
    {
        try {
            $address = $this->service->update($request,$id);
            return $this->jsonResponseSuccess(new AddressResource($address));
        } catch (Exception $e) {
            $this->logError('Address creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }
}

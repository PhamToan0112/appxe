<?php

namespace App\Api\V1\Http\Controllers\Bank;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Bank\BankRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Api\V1\Support\AuthServiceApi;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Ngân hàng
 */
class BankController extends Controller
{
    use Response, UseLog, AuthServiceApi;
    private static string $GUARD_API = 'api';

    public function __construct(
        BankRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
        $this->middleware('auth:api', ['except' => ['index']]);

    }

    /**
     * Lấy danh sách các ngân hàng
     *
     * API này trả về danh sách tất cả các ngân hàng có trong cơ sở dữ liệu. Điều này bao gồm thông tin cơ bản như ID và tên của ngân hàng.
     *
     * @authenticated
     * @response 200 {
     *     "status": 200,
     *     "message": "Danh sách ngân hàng đã được tải thành công.",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "Ngân hàng Ngoại thương Việt Nam (Vietcombank)"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Ngân hàng Thương mại Cổ phần Ngoại thương Việt Nam (VietinBank)"
     *         }
     *     ]
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Không thể tải danh sách ngân hàng do lỗi server."
     * }
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $banks = $this->repository->getAll();
            return $this->jsonResponseSuccess($banks);
        } catch (Exception $e) {
            $this->logError('Failed to retrieve bank list:', $e);
            return $this->jsonResponseError('Internal server error', 500);
        }
    }


}

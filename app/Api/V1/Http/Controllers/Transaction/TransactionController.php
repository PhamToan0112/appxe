<?php

namespace App\Api\V1\Http\Controllers\Transaction;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Transaction\TransactionInfoRequest;
use App\Api\V1\Http\Requests\Transaction\TransactionRequest;
use App\Api\V1\Http\Resources\Transaction\TransactionResource;
use App\Api\V1\Http\Resources\Transaction\TransactionResourceCollection;
use App\Api\V1\Repositories\Transaction\TransactionRepositoryInterface;
use App\Api\V1\Services\Transaction\TransactionServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Thông tin giao dịch
 */
class TransactionController extends Controller
{
    use Response, UseLog;

    public function __construct(TransactionRepositoryInterface $repository,
                                TransactionServiceInterface    $service)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    /**
     * Lấy danh sách giao dịch theo Loại giao dịch
     *
     * API này được sử dụng để lấy các giao dịch theo Loại giao dịch:
     *
     *     deposit - Nạp tiền
     *     withdraw - Rút tiền
     *     payment  - Thanh toán
     *
     *
     *
     * @authenticated
     *
     * @queryParam page integer nullable Example: 1
     *
     * @queryParam limit integer nullable Example: 1
     *
     * @queryParam type string optional Example: deposit
     *
     * @response 200 {
     *       "status": 200,
     *       "message": "Thực hiện thành công.",
     *       "data": {
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "id": 2,
     *                   "wallet_id": 1,
     *                   "type": "deposit",
     *                   "amount": "12100000",
     *                   "code": "TRX_66cec1fad0ced",
     *                   "created_at": "2024-08-28T06:21:46.000000Z",
     *                   "updated_at": "2024-08-28T06:21:46.000000Z"
     *               },
     *               {
     *                   "id": 1,
     *                   "wallet_id": 1,
     *                   "type": "deposit",
     *                   "amount": "20000",
     *                   "code": "TRX_66ceaac2ba03e",
     *                   "created_at": "2024-08-28T04:42:42.000000Z",
     *                   "updated_at": "2024-08-28T04:42:42.000000Z"
     *               }
     *           ],
     *           "first_page_url": "http://localhost:8080/2792-SEE/api/v1/transactions?page=1",
     *           "from": 1,
     *           "last_page": 1,
     *           "last_page_url": "http://localhost:8080/2792-SEE/api/v1/transactions?page=1",
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://localhost:8080/2792-SEE/api/v1/transactions?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "next_page_url": null,
     *           "path": "http://localhost:8080/2792-SEE/api/v1/transactions",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": 2,
     *           "total": 2
     *       }
     *   }
     *
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống."
     * }
     *
     * @param TransactionRequest $request Đối tượng request chứa dữ liệu validation cho việc kiểm tra danh sách giao dịch theo Loại giao dịch lọc theo      * page , limit .
     * @return JsonResponse Phản hồi JSON chứa kết quả kiểm tra.
     */

    public function index(TransactionRequest $request): JsonResponse
    {
        try {
            $transactions = $this->service->getTransactionByType($request);
            return $this->jsonResponseSuccess(new TransactionResourceCollection($transactions));
        } catch (Throwable $e) {
            $this->logError('User creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Lấy chi tiết giao dịch
     *
     * API này được sử dụng để lấy chi tiết giao dịch theo mã giao dịch
     *
     * @authenticated
     *
     * @queryParam code string required Example:TRX_66ceaac2ba03e
     *
     * @response 200 {
     *       "status": 200,
     *       "message": "Thực hiện thành công.",
     *       "data": [
     *           {
     *              "id": 1,
     *              "wallet_id": 1,
     *              "type": "deposit",
     *              "amount": "20000",
     *              "code": "TRX_66ceaac2ba03e",
     *              "created_at": "2024-08-28T04:42:42.000000Z",
     *              "updated_at": "2024-08-28T04:42:42.000000Z"
     *          }
     *       ]
     *   }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống."
     * }
     *
     * @param TransactionInfoRequest $request Đối tượng request chứa dữ liệu validation cho việc kiểm tra thông tin giao dịch.
     * @return JsonResponse Phản hồi JSON chứa kết quả kiểm tra.
     */

    public function getInfo(TransactionInfoRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $transactions = $this->repository->findByField('code', $data['code']);
            return $this->jsonResponseSuccess(new TransactionResource($transactions));
        } catch (Throwable $e) {
            $this->logError('User creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }


}

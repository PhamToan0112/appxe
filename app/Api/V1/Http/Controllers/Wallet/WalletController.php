<?php

namespace App\Api\V1\Http\Controllers\Wallet;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Http\Requests\Wallet\CheckBalanceRequest;
use App\Api\V1\Http\Requests\Wallet\WalletDepositRequest;
use App\Api\V1\Http\Requests\Wallet\WalletWithdrawRequest;
use App\Api\V1\Repositories\Wallet\WalletRepositoryInterface;
use App\Api\V1\Services\Wallet\WalletServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @group Ví điện tử
 */
class WalletController extends Controller
{
    use Response, UseLog;


    public function __construct(
        WalletServiceInterface    $service,

        WalletRepositoryInterface $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Kiểm tra số dư
     *
     * API này được sử dụng để kiểm tra xem số dư trong ví của người dùng
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Số dư đủ để thanh toán.",
     *     "data": 12120000
     * }
     *
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống."
     * }
     *
     * @return JsonResponse Phản hồi JSON chứa kết quả kiểm tra.
     */

     public function getBalance(): JsonResponse
     {
         try {
             $wallets = $this->service->getBalance();
             return $this->jsonResponseSuccess($wallets);
         }catch (Exception $e) {
             $this->logError('User creation failed:', $e);
             return $this->jsonResponseError($e->getMessage(), 500);
         }
     }
    /**
     * Kiểm tra số dư có đủ để thanh toán hay không
     *
     * API này được sử dụng để kiểm tra xem số dư trong ví của người dùng có đủ để thanh toán số tiền được yêu cầu hay không.
     *
     * @authenticated
     *
     * @queryParam total float required Tổng số tiền cần thanh toán. Example: 200000
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Số dư đủ để thanh toán.",
     *     "data": []
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Số dư không đủ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống."
     * }
     *
     * @param CheckBalanceRequest $request Đối tượng request chứa dữ liệu validation cho việc kiểm tra số dư.
     * @return JsonResponse Phản hồi JSON chứa kết quả kiểm tra.
     */
    public function checkBalance(CheckBalanceRequest $request): JsonResponse
    {
        try {
            $response = $this->service->checkBalance($request);
            return $this->jsonResponseSuccess($response);
        } catch (BadRequestException $e) {
            $this->logError("Check balance request failed", $e);
            return $this->jsonResponseError($e->getMessage(), 400);
        } catch (Exception $e) {
            $this->logError("Check balance request failed", $e);
            return $this->jsonResponseError("Lỗi hệ thống", 500);
        }
    }

    /**
     * Yêu cầu Nạp tiền vào ví
     *
     * API này được sử dụng để thực hiện nạp tiền vào ví của người dùng.
     * Yêu cầu nạp tiền bao gồm thông tin hình ảnh xác nhận giao dịch.
     *
     * @authenticated
     *
     * @bodyParam confirmation_image string required Hình ảnh xác nhận giao dịch. Example: https://example.com/image.jpg
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Giao dịch thành công.",
     *     "data": []
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể thực hiện nạp tiền."
     * }
     *
     * @param WalletDepositRequest $request Đối tượng request chứa dữ liệu validation cho việc nạp tiền.
     * @return JsonResponse Phản hồi JSON chứa kết quả của giao dịch.
     */
    public function deposit(WalletDepositRequest $request): JsonResponse
    {
        try {
            $this->service->deposit($request);
            return $this->jsonResponseSuccess([], 'Giao dịch thành công');
        } catch (Exception $e) {
            $this->logError("Create request failed", $e);
            return $this->jsonResponseError("Create request Deposit failed ", 500);
        }
    }

    /**
     * Yêu cầu Rút tiền từ ví
     *
     * API này được sử dụng để thực hiện yêu cầu rút tiền từ ví của người dùng.
     * Người dùng cần cung cấp thông tin số tiền cần rút và thông tin tài khoản ngân hàng để nhận tiền.
     *
     * @authenticated
     *
     * @bodyParam amount float required Số tiền cần rút. Example: 500000
     * @bodyParam bank_account_number string required Số tài khoản ngân hàng để nhận tiền. Example: 123456789
     * @bodyParam bank_name string required Tên ngân hàng. Example: Vietcombank
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Yêu cầu rút tiền thành công.",
     *     "data": []
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thông tin không hợp lệ."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Lỗi hệ thống. Không thể thực hiện rút tiền."
     * }
     *
     * @param WalletWithdrawRequest $request Đối tượng request chứa dữ liệu validation cho việc rút tiền.
     * @return JsonResponse Phản hồi JSON chứa kết quả của giao dịch.
     */
    public function withdraw(WalletWithdrawRequest $request): JsonResponse
    {
        try {
            $this->service->withdraw($request);
            return $this->jsonResponseSuccess([], 'Yêu cầu rút tiền thành công');
        } catch (Exception $e) {
            $this->logError("Withdraw request failed", $e);
            return $this->jsonResponseError("Yêu cầu rút tiền thất bại", 500);
        }
    }


}

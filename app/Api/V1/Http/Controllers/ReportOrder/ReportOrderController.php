<?php
namespace App\Api\V1\Http\Controllers\ReportOrder;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\ReportOrder\ReportOrderRequest;
use App\Api\V1\Http\Resources\ReportOrder\ReportOrderResource;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Api\V1\Services\ReportOrder\ReportOrderServiceInterface;
use App\Api\V1\Support\AuthServiceApi;

/**
 * @group Báo cáo đơn hàng
 */
class ReportOrderController extends Controller
{
    use Response, UseLog, AuthServiceApi;

    protected $service;

    public function __construct(ReportOrderServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Báo cáo đơn hàng
     *
     * API Thêm báo cáo đơn hàng của tài xế
     * 
     * @headersParam X-TOKEN-ACCESS string required Token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @bodyParam order_id integer required ID đơn hàng. Example: 1 
     * @bodyParam description string required Nội dung báo cáo đơn hàng. Example: Nội dung 1
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "order_id": 8,
     *          "driver": "Tài xế",
     *          "description": "Nội dung 1"
     *      }
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Report Order create failed.",
     * }
     *
     * @param ReportOrderRequest $request
     * @return JsonResponse
     */
    public function store(ReportOrderRequest $request): JsonResponse
    {
        try {
            $reportOrder = $this->service->store($request);
            return $this->jsonResponseSuccess(new ReportOrderResource($reportOrder));
        } catch (Exception $e) {
            $this->logError('Report Order create failed:', $e);
            return $this->jsonResponseError('Report Order create failed', 500);
        }
    }
}

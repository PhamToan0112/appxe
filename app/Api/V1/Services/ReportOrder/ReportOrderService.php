<?php

namespace App\Api\V1\Services\ReportOrder;

use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Services\ReportOrder\ReportOrderServiceInterface;
use App\Api\V1\Repositories\ReportOrder\ReportOrderRepositoryInterface;
use App\Enums\Notification\MessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use App\Api\V1\Support\UseLog;
use Exception;

class ReportOrderService implements ReportOrderServiceInterface
{
    use AuthSupport, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ReportOrderRepositoryInterface $repository;
    protected NotificationServiceInterface $notificationService;
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        ReportOrderRepositoryInterface $repository,
        OrderRepositoryInterface       $orderRepository,
        NotificationServiceInterface   $notificationService
    )
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->notificationService = $notificationService;
    }

    public function store(Request $request): bool|object
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->findOrFail($data['order_id']);

            $reportOrder = $this->repository->create($data);
            $title = config('notifications.driver_reported.title');
            $bodyTemplate = config('notifications.driver_reported.message');
            $body = str_replace('{order_code}', $order->code, $bodyTemplate);
            $body = str_replace('{driver_name}', $order->driver->user->fullname, $body);
                      
            $this->notificationService->sendNotificationsToAdmins($title, $body, MessageType::REPORT,true);

            DB::commit();
            return $reportOrder;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to create Report Order', $e);
            return false;
        }
    }
}

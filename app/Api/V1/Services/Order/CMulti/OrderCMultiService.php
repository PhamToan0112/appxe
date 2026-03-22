<?php

namespace App\Api\V1\Services\Order\CMulti;

use App\Admin\Services\File\FileService;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\DeleteStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\ShippingProgressStatus;
use App\Enums\Order\OrderMultiPointStatus;
use App\Enums\Shipment\ShipmentStatus;
use App\Traits\NotifiesViaFirebase;
use App\Api\V1\Support\AuthSupport;
use App\Models\User;
use App\Models\Order;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderCMultiService implements OrderCMultiServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog, NotifiesViaFirebase;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected OrderRepositoryInterface $repository;

    protected DriverRepositoryInterface $driverRepository;
    protected FileService $fileService;

    protected ShipmentRepositoryInterface $shipmentRepository;

    protected OrderMultiPointDetailRepositoryInterface $orderMultiPointDetailRepository;


    public function __construct(
        OrderRepositoryInterface                 $repository,
        ShipmentRepositoryInterface              $shipmentRepository,
        OrderMultiPointDetailRepositoryInterface $orderMultiPointDetailRepository,
        FileService                              $fileService
    )
    {
        $this->repository = $repository;
        $this->shipmentRepository = $shipmentRepository;
        $this->orderMultiPointDetailRepository = $orderMultiPointDetailRepository;
        $this->fileService = $fileService;
    }

    public function createCMultiOrder(Request $request): object|bool
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $data['code'] = uniqid_real(8);
            $data['order_type'] = OrderType::C_Multi;
            $data['shipment_status'] = OrderStatus::Confirmed;
            $shipmentIds = $data['shipment_ids'];
            $order = $this->repository->create($data);
            if ($request->filled('shipment_ids')) {
                $this->createMultiPointDetails($order, $shipmentIds);
            }

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to create CMultiOrder:', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    protected function createMultiPointDetails($order, array $shipmentIds): void
    {
        foreach ($shipmentIds as $shipmentId) {
            $shipment = $this->shipmentRepository->find($shipmentId);

            if ($shipment) {
                $this->shipmentRepository
                    ->updateAttribute($shipmentId, 'shipment_status', ShipmentStatus::Ordered);

                $multiPointDetailData = [
                    'order_id' => $order->id,
                    'weight_range_id' => $shipment->weight_range_id,
                    'start_latitude' => $shipment->start_latitude,
                    'start_longitude' => $shipment->start_longitude,
                    'start_address' => $shipment->start_address,
                    'end_latitude' => $shipment->end_latitude,
                    'end_longitude' => $shipment->end_longitude,
                    'end_address' => $shipment->end_address,
                    'recipient_name' => $shipment->recipient_name,
                    'recipient_phone' => $shipment->recipient_phone,
                    'collection_from_sender_status' => $shipment->collection_from_sender_status,
                    'collect_on_delivery_amount' => $shipment->collect_on_delivery_amount,
                ];

                $multiPointDetail = $this->orderMultiPointDetailRepository->create($multiPointDetailData);
                if ($shipment->categories->isNotEmpty()) {
                    $categoryIds = $shipment->categories->pluck('id')->toArray();
                    $multiPointDetail->categories()->sync($categoryIds);
                }
            }
        }
    }


    public function completeShipment(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $shipment = $this->shipmentRepository->findOrFail($data['id']);
            $data['shipping_progress_status'] = ShippingProgressStatus::Delivered;
            $deliverySuccessImage = $data['delivery_success_image'];
            if ($deliverySuccessImage) {
                $data['delivery_success_image'] = $this->fileService
                    ->uploadAvatar('images/shipment', $deliverySuccessImage, $shipment->delivery_success_image);
            }
            $this->shipmentRepository->update($shipment->id, $data);
            DB::commit();
            return $shipment;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError("Complete C-Multi", $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function updateShipmentStatusToPreparing(Request $request): bool
    {
        $data = $request->validated();
        $status = $data['status'];
        $shipmentIds = $data['shipment_ids'] ?? [];
        foreach ($shipmentIds as $shipmentId) {
            $this->shipmentRepository->findOrFail($shipmentId);
            $this->shipmentRepository->update($shipmentId, [
                'shipment_status' => $status
            ]);
        }
        return true;

    }
    
    /**
     * @throws Exception
     */
    public function updateMultiPointOrderDetailStatus(Request $request): bool
    {
        $data = $request->validated();
        $delivery_status = $data['delivery_status'];
        $multiPointDetailIds = $data['multi_point_detail_id'] ?? [];
        foreach ($multiPointDetailIds as $multiPointDetailId) {
            $orderMultiPointDetail = $this->orderMultiPointDetailRepository->findOrFail($multiPointDetailId);
            $this->orderMultiPointDetailRepository->update($multiPointDetailId, [
                'delivery_status' => $delivery_status        
            ]);    

            if($orderMultiPointDetail){

                $user = $orderMultiPointDetail->order->user;
                $order = $orderMultiPointDetail->order;
    
                switch ($orderMultiPointDetail->delivery_status) {
                    case OrderMultiPointStatus::Pending :
                        $titleStatus = config('notifications.order_status_pending.title');
                        $bodyTemplate = config('notifications.order_status_pending.message');
                        break;
                    
                    case OrderMultiPointStatus::Delivering :
                        $titleStatus = config('notifications.order_status_delivering.title');
                        $bodyTemplate = config('notifications.order_status_delivering.message');
                        break;
                    
                    case OrderMultiPointStatus::Delivered :
                        $titleStatus = config('notifications.order_status_delivered.title');
                        $bodyTemplate = config('notifications.order_status_delivered.message');
                        break;
                    
                    case OrderMultiPointStatus::Completed :
                        $titleStatus = config('notifications.order_status_completed.title');
                        $bodyTemplate = config('notifications.order_status_completed.message');
                        break;
                    
                    default:
                        $titleStatus = [];
                        $bodyTemplate = [];
                        break;
                }
    
                $title = $titleStatus;
                $bodyTemplate = $bodyTemplate;
                $body = str_replace('{order_code}', $order->code, $bodyTemplate);
                $this->sendFirebaseNotificationToUser($user, $title, $body);
            }

        }
        return true;

    }

    public function getShipments(Request $request)
    {
        $data = $request->validated();
        $type = $data['type'] ?? null;
        $userId = $this->getCurrentUserId();

        $query = $this->shipmentRepository->getByQueryBuilder([
            ['shipment_status', '!=', ShipmentStatus::Deleted],
            ['user_id', '=', $userId],
        ])->with(['user', 'weightRange']);

        if ($type) {
            $query->where('shipment_status', '=', $type);
        } else {
            $query->where('shipment_status', '!=', ShipmentStatus::Unsorted);
        }

        return $query->get();
    }

}

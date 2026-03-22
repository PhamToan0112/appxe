<?php

namespace App\Admin\Services\OrderMultiPointDetail;

use App\Admin\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Enums\Order\OrderMultiPointStatus;
use App\Traits\NotifiesViaFirebase;

class OrderMultiPointDetailService implements OrderMultiPointDetailServiceInterface
{
    use NotifiesViaFirebase;

    protected $orderMultiPointDetailRepository;

    public function __construct(
        OrderMultiPointDetailRepositoryInterface $orderMultiPointDetailRepository
    ) {
        $this->orderMultiPointDetailRepository = $orderMultiPointDetailRepository;
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $id = $data['id'];
        $data['start_latitude'] = $data['lat'];
        $data['start_longitude'] = $data['lng'];
        $data['start_address'] = $data['address'];
        $data['end_latitude'] = $data['end_lat'];
        $data['end_longitude'] = $data['end_lng'];
        $categories = $data['categories'] ?? [];

        $orderMultiPointDetail = $this->orderMultiPointDetailRepository->findOrFail($id);

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

        $orderMultiPointDetail->categories()->sync($categories);

        return $this->orderMultiPointDetailRepository->update($id, $data);
    }

}

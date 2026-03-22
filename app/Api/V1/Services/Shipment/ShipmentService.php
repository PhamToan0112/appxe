<?php

namespace App\Api\V1\Services\Shipment;

use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use App\Enums\Shipment\ShipmentStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;

class ShipmentService implements ShipmentServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ShipmentRepositoryInterface $repository;

    protected OrderRepositoryInterface $orderRepository;


    public function __construct(
        ShipmentRepositoryInterface $repository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
    }


    public function store(Request $request): bool|object
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['user_id'] = $this->getCurrentUserId();
            $data['shipment_status'] = ShipmentStatus::Draft;
            $shipment = $this->repository->create($data);
            if ($request->filled('category_ids')) {
                $shipment->categories()->attach($data['category_ids']);
            }
            DB::commit();
            return $shipment;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function delete(Request $request)
    {
        $data = $request->validated();

        //data là mảng chứa id của các shipment cần xóa
        $shipmentIds = $data['shipment_ids'];

        foreach ($shipmentIds as $shipmentId) {
            $shipment = $this->repository->find($shipmentId);
            if ($shipment) {
                $shipment->categories()->detach();
                $shipment->delete();
            }
        }

        return true;
    }
}
<?php

namespace App\Admin\Services\Shipment;

use App\Admin\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Enums\DeleteStatus;
use Illuminate\Http\Request;

class ShipmentService implements ShipmentServiceInterface
{
    protected $repository;

    public function __construct(ShipmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $shipmentId = $data['id'];
        $categories = $data['categories'] ?? [];

        $shipment = $this->repository->findOrFail($shipmentId);
        $shipment->categories()->sync($categories);

        $data['start_latitude'] = $data['lat'];
        $data['start_longitude'] = $data['lng'];
        $data['start_address'] = $data['address'];
        $data['end_latitude'] = $data['end_lat'];
        $data['end_longitude'] = $data['end_lng'];

        return $this->repository->update($shipmentId, $data);
    }

    public function delete(int $id): mixed
    {
        $shipment = $this->repository->findOrFail($id);
        if ($shipment) {
            $shipment->is_deleted = DeleteStatus::Deleted;
        }
        return $shipment->save();
    }
}
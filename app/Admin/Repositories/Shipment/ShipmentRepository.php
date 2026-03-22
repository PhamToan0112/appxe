<?php

namespace App\Admin\Repositories\Shipment;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Shipment;

class ShipmentRepository extends EloquentRepository implements ShipmentRepositoryInterface
{
    public function getModel(): string
    {
        return Shipment::class;
    }

}

<?php

namespace App\Admin\Repositories\OrderMultiPointDetail;
use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderMultiPointDetail;

class OrderMultiPointDetailRepository extends EloquentRepository implements OrderMultiPointDetailRepositoryInterface
{
    public function getModel(): string
    {
        return OrderMultiPointDetail::class;
    }

}

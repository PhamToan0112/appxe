<?php

namespace App\Admin\Repositories\RecentLocation;
use App\Admin\Repositories\EloquentRepository;
use App\Models\RecentLocation;

class RecentLocationRepository extends EloquentRepository implements RecentLocationRepositoryInterface
{


    public function getModel(): string
    {
        return RecentLocation::class;
    }

}

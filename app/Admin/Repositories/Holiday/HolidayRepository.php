<?php

namespace App\Admin\Repositories\Holiday;
use App\Admin\Repositories\EloquentRepository;
use App\Models\Holiday;

class HolidayRepository extends EloquentRepository implements HolidayRepositoryInterface
{
    public function getModel(): string
    {
        return Holiday::class;
    }


    public function getHoliday($driverId)
    {
        
    }
}

<?php

namespace App\Admin\Repositories\Holiday;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface HolidayRepositoryInterface extends EloquentRepositoryInterface
{
    public function getHoliday($driverId);
}
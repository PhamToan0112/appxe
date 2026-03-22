<?php

namespace App\Admin\Services\Review;
use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function getReviews($id);

    public function delete($id);
}
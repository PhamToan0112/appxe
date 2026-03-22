<?php

namespace App\Api\V1\Services\ReportOrder;

use Illuminate\Http\Request;

interface ReportOrderServiceInterface
{

    public function store(Request $request);

}

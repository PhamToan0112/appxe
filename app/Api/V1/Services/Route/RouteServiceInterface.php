<?php

namespace App\Api\V1\Services\Route;

use Illuminate\Http\Request;

interface RouteServiceInterface
{
    public function create(Request $request);
    public function search(Request $request);

}

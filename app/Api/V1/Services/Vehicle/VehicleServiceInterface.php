<?php

namespace App\Api\V1\Services\Vehicle;
use Illuminate\Http\Request;

interface VehicleServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);
    public function delete($id);



}

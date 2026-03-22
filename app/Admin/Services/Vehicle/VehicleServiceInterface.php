<?php

namespace App\Admin\Services\Vehicle;
use Illuminate\Http\Request;

interface VehicleServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete($id);

    public function actionMultipleRecode(Request $request): bool;
}

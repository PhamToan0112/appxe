<?php

namespace App\Admin\Services\Driver;
use Illuminate\Http\Request;

interface DriverServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete(int $id);

    public function approve($id);
    public function reject($id);

    public function pendingDriverMultipleRecode(Request $request);

    public function actionDriverMultipleRecode(Request $request);
}

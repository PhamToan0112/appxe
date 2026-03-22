<?php

namespace App\Api\V1\Services\Driver;
use Illuminate\Http\Request;

interface DriverServiceInterface
{
    public function store(Request $request): mixed;
    public function update(Request $request): bool;
    public function search(Request $request);

    public function getDriver();

    public function updateDriverConfigs(Request $request);

    public function getDriverInfo(Request $request);
}
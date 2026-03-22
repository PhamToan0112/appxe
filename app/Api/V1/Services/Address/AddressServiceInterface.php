<?php

namespace App\Api\V1\Services\Address;

use Illuminate\Http\Request;

interface AddressServiceInterface
{
    public function index(Request $request);
    public function delete($id): object|bool;
    public function store(Request $request): bool|object;
    public function update(Request $request, $id): bool|object;
}

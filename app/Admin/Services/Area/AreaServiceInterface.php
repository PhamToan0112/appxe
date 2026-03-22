<?php

namespace App\Admin\Services\Area;

use Illuminate\Http\Request;

interface AreaServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete(int $id);

}

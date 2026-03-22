<?php

namespace App\Admin\Services\Holiday;

use Illuminate\Http\Request;

interface HolidayServiceInterface
{

    public function store(Request $request);


    public function update(Request $request);


    public function delete($id);


}

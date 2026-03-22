<?php

namespace App\Admin\Services\Discount;
use Illuminate\Http\Request;

interface DiscountApplicationServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete($id);


}

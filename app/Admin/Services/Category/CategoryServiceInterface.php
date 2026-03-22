<?php

namespace App\Admin\Services\Category;
use Illuminate\Http\Request;

interface CategoryServiceInterface
{
    /**
     * Tạo mới
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * Cập nhật
     *
     * @param Request $request
     * @return boolean
     */
    public function update(Request $request);
}

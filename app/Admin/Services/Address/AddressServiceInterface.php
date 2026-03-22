<?php

namespace App\Admin\Services\Address;

use Illuminate\Http\Request;

interface AddressServiceInterface
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

    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id);

}

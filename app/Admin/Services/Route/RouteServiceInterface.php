<?php

namespace App\Admin\Services\Route;

use Illuminate\Http\Request;

interface RouteServiceInterface
{
    /**
     * Tạo mới
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed;

    /**
     * Cập nhật
     *
     * @param Request $request
     * @return bool|object
     */
    public function update(Request $request): mixed;

    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id): mixed;

    public function actionMultipleRecord(Request $request);
}

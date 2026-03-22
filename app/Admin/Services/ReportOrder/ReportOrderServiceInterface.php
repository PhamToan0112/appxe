<?php

namespace App\Admin\Services\ReportOrder;
use Illuminate\Http\Request;

interface ReportOrderServiceInterface
{
    /**
     * Xóa
     *  
     * @param int $id
     * 
     * @return boolean
     */
    public function delete($id);

}
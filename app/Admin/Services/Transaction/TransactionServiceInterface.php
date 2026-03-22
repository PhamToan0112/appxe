<?php 
namespace App\Admin\Services\Transaction;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Http\Request;


interface TransactionServiceInterface{
    /**
     * Cập nhật
     * 
     * @var Illuminate\Http\Request $request
     * 
     * @return boolean
     */
    public function update(Request $request);
}
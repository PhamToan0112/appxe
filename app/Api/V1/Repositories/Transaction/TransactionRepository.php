<?php

namespace App\Api\V1\Repositories\Transaction;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Transaction\TransactionRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use App\Models\Transaction;

class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface {

    use AuthServiceApi, UseLog;
    protected $select = [];

    public function getModel() {
        return Transaction::class;
    }

    public function findByKey($key, $value) {
        $this->instance = $this->model->where($key, $value)->first();
        return $this->instance;
    }

    public function paginateTransactionsByType( $limit, $page , $type){
        $user = $this->getCurrentUser();
        if(!$type){
            return  $user->wallet->transactions()->paginate($limit, ['*'], 'page', $page);
        }
        return  $user->wallet->transactions()->where('type', $type)->paginate($limit, ['*'], 'page', $page);
    }

    public function getTransactionsByCode($code){
        $user = $this->getCurrentUser();
        return  $user->wallet->transactions->where('code', $code);
    }
}

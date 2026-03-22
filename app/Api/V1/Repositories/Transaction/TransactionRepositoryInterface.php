<?php

namespace   App\Api\V1\Repositories\Transaction;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface TransactionRepositoryInterface extends EloquentRepositoryInterface{
    public function findByKey($key, $value);
    public function paginateTransactionsByType($limit, $page , $type);
    public function getTransactionsByCode($code);
}
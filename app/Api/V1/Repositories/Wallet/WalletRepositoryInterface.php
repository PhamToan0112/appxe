<?php

namespace   App\Api\V1\Repositories\Wallet;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface WalletRepositoryInterface extends EloquentRepositoryInterface{
    public function findByKey($key, $value);
}
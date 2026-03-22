<?php

namespace App\Api\V1\Repositories\Wallet;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Wallet\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository extends EloquentRepository implements WalletRepositoryInterface {
    protected $select = [];

    public function getModel() {
        return Wallet::class;
    }

    public function findByKey($key, $value) {
        $this->instance = $this->model->where($key, $value)->first();
        return $this->instance;
    }
}

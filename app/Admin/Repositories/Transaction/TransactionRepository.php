<?php

namespace App\Admin\Repositories\Transaction;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Transaction;
use App\Models\User;

class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    public function getModel(): string
    {
        return Transaction::class;
    }
    public function getUserById($userId)
    {
        return User::find($userId);
    }
}

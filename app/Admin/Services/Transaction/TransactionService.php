<?php

namespace App\Admin\Services\Transaction;

use App\Admin\Services\Transaction\TransactionServiceInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use App\Enums\Transaction\TransactionStatus;

class TransactionService implements TransactionServiceInterface
{
    protected $data;
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request): object|bool
    {
        $this->data = $request->validated();
        return $this->repository->update($this->data['id'], $this->data);
    }

    
}

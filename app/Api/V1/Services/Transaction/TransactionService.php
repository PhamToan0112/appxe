<?php

namespace App\Api\V1\Services\Transaction;

use App\Api\V1\Services\Transaction\TransactionServiceInterface;
use App\Api\V1\Repositories\Transaction\TransactionRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Exception;

class TransactionService implements TransactionServiceInterface
{
    use AuthServiceApi;

    protected TransactionRepositoryInterface $repository;

    public function __construct(
        TransactionRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function getTransactionByType($request)
    {
        $data = $request->validated();
        $user = $this->getCurrentUser();
        $wallet = $user->wallet;

        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;
        $type = $data['type'] ?? null;

        $filters = ['wallet_id' => $wallet->id];

        if ($type) {
            $filters['type'] = $type;
        }

        return $this->repository->getByQueryBuilder($filters)
            ->paginate($limit, ['*'], 'page', $page);
    }


}

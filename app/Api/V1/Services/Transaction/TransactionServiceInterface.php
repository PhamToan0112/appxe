<?php

namespace App\Api\V1\Services\Transaction;

interface TransactionServiceInterface {
    public function getTransactionByType($request);
}

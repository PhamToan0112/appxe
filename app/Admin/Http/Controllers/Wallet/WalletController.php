<?php

namespace App\Admin\Http\Controllers\Wallet;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Transaction\DepositTransactionRequest;
use App\Admin\Http\Requests\Transaction\WithdrawTransactionRequest;
use App\Admin\Http\Requests\Wallet\WalletRequest;
use App\Admin\Repositories\Wallet\WalletRepositoryInterface;
use App\Admin\Services\Wallet\WalletServiceInterface;
use App\Traits\ResponseController;


class WalletController extends Controller
{
    use ResponseController;


    public function __construct(
        WalletRepositoryInterface $repository,
        WalletServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function deposit(DepositTransactionRequest $request)
    {
        return $this->service->deposit($request);
    }

    public function withdraw(WithdrawTransactionRequest $request)
    {
        return $this->service->withdraw($request);
    }
    public function getBalance(WalletRequest $request)
    {
        return $this->service->getBalance($request);

    }



}

<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Services\Transaction\TransactionServiceInterface;
use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Admin\Http\Requests\Transaction\TransactionRequest;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Traits\ResponseController;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    use ResponseController;

    public function __construct(
        TransactionRepositoryInterface $repository,
        TransactionServiceInterface $service
    ){
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.transactions.index',
            'edit' => 'admin.transactions.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.transaction.index',
            'edit' => 'admin.transaction.edit',
            'delete' => 'admin.transaction.delete'
        ];
    }

    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('transactions'))
        ]);
    }

    /**
     * @throws Exception
     */
    public function edit($id): View|Application
    {
        $transaction = $this->repository->findOrFail($id);
        $userId = $transaction->wallet->user_id;
        return view(
            $this->view['edit'],
            [
                'type' => TransactionType::asSelectArray(),
                'is_deleted' => TransactionStatus::asSelectArray(),
                'transaction' => $transaction,
                'user' => $this->repository->getUserById($userId),
                'wallet_id' => $transaction['wallet_id']
            ]
        );
    }

    public function update(TransactionRequest $request): RedirectResponse
        {   
            $response = $this->service->update($request);
            return $this->handleUpdateResponse($response);
        }

    public function delete($id)
    {
        $response = $this->repository->findOrFail($id);
        $response->update(['is_deleted' => TransactionStatus::DELETED->value]);
        return $this->handleUpdateResponse($response);
    }
}
<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Enums\DeleteStatus;
use App\Enums\Transaction\TransactionType;


class TransactionDataTable extends BaseDataTable
{


    protected $nameTable = 'TransactionTable';


    public function __construct(
        TransactionRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.transactions.datatable.action',
            'type' => 'admin.transactions.datatable.type',
            'code' => 'admin.transactions.datatable.code',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchDate = [1];

        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => TransactionType::asSelectArray()
            ],

        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder(['is_deleted' => DeleteStatus::NotDeleted]);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.transaction', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'created_at' => '{{ $created_at ? format_datetime($created_at) : "" }}',
            'type' => $this->view['type'],
            'code' => $this->view['code'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'type', 'code', 'is_deleted'];
    }
}

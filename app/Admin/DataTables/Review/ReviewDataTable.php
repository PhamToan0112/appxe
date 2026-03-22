<?php

namespace App\Admin\DataTables\Review;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Review\ReviewStatus;

class ReviewDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'reviewsTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        ReviewRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'user_id' => 'admin.drivers.reviews.datatable.user',
            'order_id' => 'admin.drivers.reviews.datatable.order',
            'rating' => 'admin.drivers.reviews.datatable.rating',
            'content' => 'admin.drivers.reviews.datatable.content',
            'status' => 'admin.drivers.reviews.datatable.status',
            'created_at' => 'admin.drivers.reviews.datatable.created_at',
            'action' => 'admin.drivers.reviews.datatable.action',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];

        $this->columnSearchDate = [5];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => ReviewStatus::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->repository->getReviews(request()->route('id'));
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.reviews', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'user_id' => function ($item) {
                return view($this->view['user_id'], [
                    'id' => $item->user->id,
                    'fullname' => $item->user->fullname,
                ])->render();
            },

            'order_id' => function ($item) {
                return view($this->view['order_id'], [
                    'id' => $item->order->id,
                    'code' => $item->order->code,
                    'type' => $item->order->order_type,
                ])->render();
            },
            'rating' => $this->view['rating'],
            'content' => $this->view['content'],
            'status' => $this->view['status'],
            'created_at' => '{{ date("d-m-Y H:i", strtotime($created_at)) }}',
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'user_id' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', "%$keyword%");
                });
            },
            'order_id' => function ($query, $keyword) {
                $query->whereHas('order', function ($subQuery) use ($keyword) {
                    $subQuery->where('code', 'like', "%$keyword%");
                });
            },
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
        $this->customRawColumns = ['user_id', 'order_id', 'rating', 'content', 'status', 'created_at', 'action'];
    }

}

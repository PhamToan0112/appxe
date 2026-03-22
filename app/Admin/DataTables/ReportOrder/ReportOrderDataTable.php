<?php

namespace App\Admin\DataTables\ReportOrder;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\ReportOrder\ReportOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ReportOrderDataTable extends BaseDataTable
{


    protected $nameTable = 'reportOrderTable';


    public function __construct(
        ReportOrderRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.report_orders.datatable.action',
            'code' => 'admin.report_orders.datatable.code',
            'users' => 'admin.report_orders.datatable.users',
            'drivers' => 'admin.report_orders.datatable.drivers',
            'description' => 'admin.report_orders.datatable.description',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3];

        $this->columnSearchSelect = [];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([])
            ->whereHas('issues', function($query) {
            $query->whereNotNull('order_id');
        });
    }



    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.report_order', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'drivers' => function ($order) {
                $driver = $order->driver->user ?? null;
                return view($this->view['drivers'], compact('driver'))->render();
            },
            'description' => function ($order) {
                $orderId = $order->id;
                $orderIssue = $this->repository->getOrderIssue($orderId);
                return view($this->view['description'], compact('orderIssue'))->render();
            },

            'users' => function ($order) {
                $user = $order->user ?? null;
                return view($this->view['users'], compact('user'))->render();
            },
            'code' => function ($order) {
                $code = $order->code;
                $orderId = $order->id;
                $orderType = $order->order_type;
                return view($this->view['code'], compact(['code', 'orderId','orderType']))->render();
            },
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'code' => function ($query, $keyword) {
                $query->where('code', 'like', "%$keyword%");
            },
            'users' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'drivers' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'description' => function ($query, $keyword) {
                $query->whereHas('issues', function ($subQuery) use ($keyword) {
                    $subQuery->where('description', 'like', '%' . $keyword . '%');
                });
            }
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'code',
            'users',
            'drivers',
            'description',
            'action'
        ];
    }
}

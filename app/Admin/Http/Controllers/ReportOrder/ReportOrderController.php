<?php

namespace App\Admin\Http\Controllers\ReportOrder;

use App\Admin\DataTables\ReportOrder\ReportOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\ReportOrder\ReportOrderRepositoryInterface;
use App\Admin\Services\ReportOrder\ReportOrderServiceInterface;
use App\Traits\ResponseController;
use Exception;

use Illuminate\Http\RedirectResponse;

class ReportOrderController extends Controller
{
    use ResponseController;

    public function __construct(
        ReportOrderRepositoryInterface $repository,
        ReportOrderServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.report_orders.index',
            'create' => 'admin.report_orders.create',
            'edit' => 'admin.report_orders.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.report_order.index',
            'delete' => 'admin.report_order.delete'
        ];
    }

    public function index(ReportOrderDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'],
        [
            'breadcrumbs' => $this->crums->add(__('report_list')),

        ]);
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }
}

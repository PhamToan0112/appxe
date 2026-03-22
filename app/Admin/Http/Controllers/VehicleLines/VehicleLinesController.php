<?php

namespace App\Admin\Http\Controllers\VehicleLines;

use App\Admin\DataTables\VehicleLines\VehicleLinesDataTable;
use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\VehicleLines\VehicleLinesRequest;
use App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface;
use App\Admin\Services\VehicleLines\VehicleLinesServiceInterface;
use App\Enums\DefaultStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleLinesController extends BaseController
{
    use ResponseController;

    protected VehicleLinesRepositoryInterface $repository;
    protected VehicleLinesServiceInterface $service;

    public function __construct(
        VehicleLinesRepositoryInterface $repository,
        VehicleLinesServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.vehicleLines.index',
            'create' => 'admin.vehicleLines.create',
            'edit' => 'admin.vehicleLines.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.VehicleLine.index',
            'create' => 'admin.VehicleLine.create',
            'edit' => 'admin.VehicleLine.edit',
            'delete' => 'admin.VehicleLine.delete',
        ];
    }

    public function index(VehicleLinesDataTable $dataTable)
    {   
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render(
            $this->view['index'],
            [
                'actionMultiple' => $actionMultiple,
                'breadcrumbs' => $this->crums->add(__('vehicleLineList')),

            ]
        );
    }


    public function create(): Factory|View|Application
    {
        return view(
            $this->view['create'],
            [
                'status' => DefaultStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('vehicleLineList'), route($this->route['index']))->add(__('add'))
            ]
        );
    }

    public function store(VehicleLinesRequest $request): RedirectResponse
    {
        $vehicleLines = $this->service->store($request);

        return $this->handleResponse($vehicleLines, $request, $this->route['index'], $this->route['edit']);
    }


    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $vehicleLines = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'vehicleLines' => $vehicleLines,
                'status' => DefaultStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('vehicleLineList'), route($this->route['index']))->add(__('add'))
            ],
        );
    }


    public function update(VehicleLinesRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);
    }

    // public function delete($id): RedirectResponse
    // {

    //     $this->service->delete($id);
    //     return to_route($this->route['index'])->with('success', __('notifySuccess'));
    // }

    protected function getActionMultiple(): array
    {   
        return [
            'published' => DefaultStatus::Published->description(),
            'draft' => DefaultStatus::Draft->description(),
            'deleted' => DefaultStatus::Deleted->description(),
        ];
    }

    public function actionMultipleRecode(Request $request): RedirectResponse
    {   
        $boolean = $this->service->actionMultipleRecode($request);
        if ($boolean) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
}
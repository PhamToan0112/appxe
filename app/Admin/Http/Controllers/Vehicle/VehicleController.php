<?php

namespace App\Admin\Http\Controllers\Vehicle;

use App\Admin\DataTables\Vehicle\VehicleDataTable;
use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\Vehicle\VehicleRequest;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Enums\Order\OrderType;
use App\Enums\User\Gender;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Vehicle\LicensePlateColor;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VehicleController extends BaseController
{
    use ResponseController;

    protected VehicleRepositoryInterface $repository;
    protected VehicleServiceInterface $service;

    public function __construct(
        VehicleRepositoryInterface $repository,
        VehicleServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.vehicle.index',
            'create' => 'admin.vehicle.create',
            'edit' => 'admin.vehicle.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.vehicle.index',
            'create' => 'admin.vehicle.create',
            'edit' => 'admin.vehicle.edit',
            'delete' => 'admin.vehicle.delete',
        ];
    }

    public function index(VehicleDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render(
            $this->view['index'],
            [
                'type' => VehicleType::asSelectArray(),
                'actionMultiple' => $actionMultiple,
                'breadcrumbs' => $this->crums->add(__('vehicleList')),
            ]
        );
    }


    public function create(): Factory|View|Application
    {
        $vehicleLine = $this->repository->getVehicleLine();
        return view(
            $this->view['create'],
            [
                'vehicle_line' => $vehicleLine,
                'order_type' => OrderType::asSelectArray(),
                'status' => VehicleStatus::asSelectArray(),
                'type' => VehicleType::asSelectArray(),
                'license_plate_color' => LicensePlateColor::asSelectArray(),
                'gender' => Gender::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('vehicleList'), route($this->route['index']))->add(__('add'))
            ]
        );
    }

    public function store(VehicleRequest $request): RedirectResponse
    {   
        $vehicle = $this->service->store($request);
        
        return $this->handleResponse($vehicle, $request, $this->route['index'], $this->route['edit']);
    }


    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $vehicle = $this->repository->findOrFail($id);
        $order_type = OrderType::asSelectArray();

        return view(
            $this->view['edit'],
            [
                'vehicle' => $vehicle,
                'order_type' => OrderType::asSelectArray(),
                'service_type' => json_decode($vehicle->service_type),
                'status' => VehicleStatus::asSelectArray(),
                'type' => VehicleType::asSelectArray(),
                'license_plate_color' => LicensePlateColor::asSelectArray(),
                'gender' => Gender::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('vehicleList'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }


    public function update(VehicleRequest $request): RedirectResponse
    {   
        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);
    }

    public function delete($id): RedirectResponse
    {
        $response = $this->repository->findOrFail($id);
        $response->update(['status' => VehicleStatus::Inactive->value]);
        return $this->handleUpdateResponse($response);
    }

    protected function getActionMultiple(): array
    {
        return [
            'active' => VehicleStatus::Active->description(),
            'inactive' => VehicleStatus::Inactive->description(),
            'deleted' => VehicleStatus::Deleted->description(),
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
<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\CRideCarDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderCRideCarRequest;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Enums\Order\OrderCRideCarStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CRideCarController extends Controller
{
    use ResponseController;

    protected VehicleRepositoryInterface $vehicleRepository;

    public function __construct(
        OrderRepositoryInterface   $repository,
        VehicleRepositoryInterface $vehicleRepository,
        OrderServiceInterface      $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->vehicleRepository = $vehicleRepository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.c-ride-car.index',
            'create' => 'admin.c-ride-car.create',
            'edit' => 'admin.c-ride-car.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.cRide.index',
            'create' => 'admin.cRide.create',
            'edit' => 'admin.cRide.edit',
            'delete' => 'admin.cRide.delete',
        ];
    }

    public function index(CRideCarDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => OrderStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('C-RideCar'))
        ]);
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $order = $this->repository->findOrFail($id);
        $driverId = $order->driver_id;
        switch ($order->order_type) {
            case  OrderType::C_RIDE:
                $vehicleTypes = [
                    VehicleType::Motorcycle,
                ];
                break;

            case OrderType::C_CAR:
                $vehicleTypes = [
                    VehicleType::Car4,
                    VehicleType::Car7,
                ];
                break;

            default:
                $vehicleTypes = []; 
                break;
        }
        $vehicle = $this->vehicleRepository->getByQueryBuilder(
            [
                ['driver_id', '=', $driverId],
            ])->whereIn('type',$vehicleTypes)->get();
        $shipment = $order->shipments->first();
        $orderIssue = null;
        if ($order->status->value == "returned") {
            $orderId = $order->id;
            $orderIssue = $this->repository->getOrderIssue($orderId);
        }
        return view(
            $this->view['edit'],
            [
                'order' => $order,
                'vehicle' => $vehicle,
                'payment_method' => PaymentMethod::asSelectArray(),
                'status' => OrderCRideCarStatus::asSelectArray(),
                'shipment' => $shipment,
                'order_issue' => $orderIssue,
                'breadcrumbs' => $this->crums->add(
                    __('C-Ride/Car'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(OrderCRideCarRequest $request): RedirectResponse
    {

        $response = $this->service->updateCRideCar($request);

        return $this->handleUpdateResponse($response);
    }
}

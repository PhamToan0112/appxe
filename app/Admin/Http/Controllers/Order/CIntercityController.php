<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\CIntercityDataTable;
use App\Admin\DataTables\Routes\RoutesDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderCIntercityRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\OpenStatus;
use App\Enums\Order\OrderCIntercityStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class CIntercityController extends Controller
{
    use ResponseController;

    protected WeightRangeRepositoryInterface $rangeRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected VehicleRepositoryInterface $vehicleRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        WeightRangeRepositoryInterface $rangeRepository,
        OrderServiceInterface $service,
        CategoryRepositoryInterface $categoryRepository,
        VehicleRepositoryInterface $vehicleRepository,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->rangeRepository = $rangeRepository;
        $this->service = $service;
        $this->categoryRepository = $categoryRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.c-intercity.index',
            'create' => 'admin.c-intercity.create',
            'edit' => 'admin.c-intercity.edit',
            'routes' => 'admin.c-intercity.routes.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.cIntercity.index',
            'create' => 'admin.cIntercity.create',
            'edit' => 'admin.cIntercity.edit',
            'delete' => 'admin.cIntercity.delete',
            'routes' => 'admin.cIntercity.routes',
            'deleteRoute' => 'admin.cIntercity.index',
        ];
    }

    public function index(CIntercityDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => OrderStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('C-Intercity'))
        ]);
    }

    public function routes(RoutesDataTable $dataTable)
    {
        return $dataTable->render($this->view['routes'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách chuyến đi')),
            'actionMultiple' => [
                'delete' => 'Xóa mục đã chọn',
            ]
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
            case OrderType::C_Intercity:
                $vehicleTypes = [
                    VehicleType::Car4,
                    VehicleType::Car7
                ];
                break;

            default:
                $vehicleTypes = [];
                break;
        }
        $vehicle = $this->vehicleRepository->getByQueryBuilder(
            [
                ['driver_id', '=', $driverId],
                ['status', '=', VehicleStatus::Active],
                ['type', 'IN', $vehicleTypes]
            ]
        )->get();

        $shipment = $order->shipments->first();
        return view(
            $this->view['edit'],
            [
                'order' => $order,
                'vehicle' => $vehicle,
                'payment_method' => PaymentMethod::asSelectArray(),
                'collection_from_sender_status' => OpenStatus::asSelectArray(),
                'status' => OrderCIntercityStatus::asSelectArray(),
                'trip_type' => TripType::asSelectArray(),
                'payment_role' => PaymentRole::asSelectArray(),
                'shipment' => $shipment,
                'breadcrumbs' => $this->crums->add(
                    __('C-Intercity'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(OrderCIntercityRequest $request): RedirectResponse
    {

        $response = $this->service->updateCIntercity($request);

        return $this->handleUpdateResponse($response);

    }



}

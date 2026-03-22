<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\CDeliveryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderCDeliveryRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\DefaultStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CDeliveryController extends Controller
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
        VehicleRepositoryInterface $vehicleRepository
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
            'index' => 'admin.c-delivery.index',
            'create' => 'admin.c-delivery.create',
            'edit' => 'admin.c-delivery.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.cDelivery.index',
            'create' => 'admin.cDelivery.create',
            'edit' => 'admin.cDelivery.edit',
            'delete' => 'admin.cDelivery.delete',
        ];
    }

    public function index(CDeliveryDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => OrderStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('C-Delivery'))
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
            case  OrderType::C_Delivery:
                $vehicleTypes = [
                    VehicleType::Motorcycle,
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
                ['status', '=', VehicleStatus::Active],
                ['type', 'IN', $vehicleTypes] 
            ]
        )->get();
        
        $weightRanges = $this->rangeRepository->getBy(['status' => DefaultStatus::Published]);
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
                'order_issue' => $orderIssue,
                'payment_method' => PaymentMethod::asSelectArray(),
                'collection_from_sender_status' => OpenStatus::asSelectArray(),
                'weightRanges' => $weightRanges,
                'status' => OrderCDeliveryStatus::asSelectArray(),
                'categories' => $this->categoryRepository->getAll(),
                'payment_role' => PaymentRole::asSelectArray(),
                'delivery_status' => DeliveryStatus::asSelectArray(),
                'advance_payment_status' => OpenStatus::asSelectArray(),
                'shipment' => $shipment,
                'breadcrumbs' => $this->crums->add(
                    __('C-Delivery'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(OrderCDeliveryRequest $request): RedirectResponse
    {

        $response = $this->service->updateCDelivery($request);

        return $this->handleUpdateResponse($response);

    }


}
<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\CMultiDataTable;
use App\Admin\DataTables\Shipment\ShipmentDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderCDeliveryRequest;
use App\Admin\Http\Requests\Order\OrderCMultiRequest;
use App\Admin\Http\Requests\Shipment\ShipmentRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Admin\Services\Shipment\ShipmentServiceInterface;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\DefaultStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderCMultiStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipment\ShipmentStatus;
use App\Enums\Order\ShippingProgressStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CMultiController extends Controller
{
    use ResponseController;

    protected WeightRangeRepositoryInterface $rangeRepository;

    protected ShipmentServiceInterface $shipmentService;
    protected ShipmentRepositoryInterface $shipmentRepository;
    protected VehicleRepositoryInterface $vehicleRepository;
    protected $categoryRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        WeightRangeRepositoryInterface $rangeRepository,
        OrderServiceInterface $service,
        ShipmentServiceInterface $shipmentService,
        ShipmentRepositoryInterface $shipmentRepository,
        CategoryRepositoryInterface $categoryRepository,
        VehicleRepositoryInterface $vehicleRepository,

    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->rangeRepository = $rangeRepository;
        $this->service = $service;
        $this->shipmentService = $shipmentService;
        $this->shipmentRepository = $shipmentRepository;
        $this->categoryRepository = $categoryRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.c-multi.index',
            'create' => 'admin.c-multi.create',
            'edit' => 'admin.c-multi.edit',
            'shipment' => 'admin.shipment.index',
            'editShipment' => 'admin.shipment.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.cMulti.index',
            'create' => 'admin.cMulti.create',
            'edit' => 'admin.cMulti.edit',
            'delete' => 'admin.cMulti.delete',
            'shipment' => 'admin.cMulti.shipment',
            'editShipment' => 'admin.cMulti.editShipment',
        ];
    }

    public function index(CMultiDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => OrderStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('C-Multi')
            )
        ]);
    }

    public function shipment(ShipmentDataTable $dataTable)
    {
        return $dataTable->render($this->view['shipment'], [
            'breadcrumbs' => $this->crums->add(
                __('Thông tin đa điểm')
            )
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
            case  OrderType::C_Multi:
                $vehicleTypes = [
                    VehicleType::Motorcycle,
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

        $weightRanges = $this->rangeRepository->getBy(['status' => DefaultStatus::Published]);

        return view(
            $this->view['edit'],
            [
                'order' => $order,
                'vehicle' => $vehicle,
                'payment_method' => PaymentMethod::asSelectArray(),
                'collection_from_sender_status' => OpenStatus::asSelectArray(),
                'weightRanges' => $weightRanges,
                'status' => OrderCMultiStatus::asSelectArray(),
                'payment_role' => PaymentRole::asSelectArray(),
                'delivery_status' => DeliveryStatus::asSelectArray(),
                'advance_payment_status' => OpenStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('C-Multi'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(OrderCMultiRequest $request): RedirectResponse
    {
        $response = $this->service->updateCMulti($request);

        return $this->handleUpdateResponse($response);

    }

    /**
     * @throws Exception
     */
    public function editShipment($id): Factory|View|Application
    {
        $shipment = $this->shipmentRepository->findOrFail($id);
        $weightRanges = $this->rangeRepository->getBy(['status' => DefaultStatus::Published]);

        return view($this->view['editShipment'], [
            'shipment' => $shipment,
            'weightRanges' => $weightRanges,
            'shipping_progress_status' => ShippingProgressStatus::asSelectArray(),
            'shipment_status' => ShipmentStatus::asSelectArray(),
            'collection_from_sender_status' => OpenStatus::asSelectArray(),
            'categories' => $this->categoryRepository->getAll(),
            'breadcrumbs' => $this->crums->add(
                __('Đơn hàng chưa lên đơn'),
                route($this->route['shipment'])
            )->add(__('edit'))
        ]);
    }

    public function updateShipment(ShipmentRequest $request): RedirectResponse
    {
        $this->shipmentService->update($request);
        return redirect()->route($this->route['shipment'])->with('success', __('notifySuccess'));
    }


    public function deleteShipment($id): RedirectResponse
    {
        $this->shipmentService->delete($id);
        return redirect()->back()->with('success', __('notifySuccess'));
    }
}
<?php

namespace App\Admin\Http\Controllers\Driver;

use App\Admin\DataTables\Discount\DriverDiscountDataTable;
use App\Admin\DataTables\Driver\DriverOrderRateDatatable;
use App\Admin\DataTables\Driver\DriverDataTable;
use App\Admin\DataTables\Driver\PendingDriverDataTable;
use App\Admin\DataTables\Driver\OrderByDriverDatatable;
use App\Admin\DataTables\Review\ReviewDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Driver\DriverRequest;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Bank\BankRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Services\Driver\DriverServiceInterface;
use App\Admin\Services\Review\ReviewServiceInterface;
use App\Enums\DefaultStatus;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\OpenStatus;
use App\Enums\User\Gender;
use App\Enums\User\UserRoles;
use App\Enums\User\UserStatus;
use App\Enums\Vehicle\VehicleType;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    use ResponseController;

    protected AreaRepositoryInterface $areaRepository;

    protected WeightRangeRepositoryInterface $weightRangeRepository;

    protected BankRepositoryInterface $bankRepository;

    protected ReviewServiceInterface $reviewService;

    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        DriverRepositoryInterface $repository,
        DriverServiceInterface $service,
        ReviewServiceInterface $reviewService,
        AreaRepositoryInterface $areaRepository,
        WeightRangeRepositoryInterface $weightRangeRepository,
        BankRepositoryInterface $bankRepository,
        OrderRepositoryInterface $orderRepository,
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
        $this->areaRepository = $areaRepository;
        $this->weightRangeRepository = $weightRangeRepository;
        $this->bankRepository = $bankRepository;
        $this->reviewService = $reviewService;
        $this->orderRepository = $orderRepository;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.drivers.index',
            'create' => 'admin.drivers.create',
            'edit' => 'admin.drivers.edit',
            'pending' => 'admin.drivers.pending',
            'reviews' => 'admin.drivers.reviews.index',
            'discount' => 'admin.drivers.discount.index',
            'route' => 'admin.drivers.index',
            'orders' => 'admin.drivers.orders.index',
            'orderRate' => 'admin.drivers.orderRate.index',
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.driver.index',
            'newDriver' => 'admin.driver.newDriver',
            'create' => 'admin.driver.create',
            'edit' => 'admin.driver.edit',
            'delete' => 'admin.driver.delete',
            'pending' => 'admin.driver.pendingVerification',
            'reviews' => 'admin.driver.reviews',
            'discount' => 'admin.driver.discount',
            'orders' => 'admin.driver.orders',
            'route' => 'admin.driver',
        ];
    }

    public function index(DriverDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('driver')),
            'actionMultiple' => $this->getDriverActionMultiple(),
        ]);
    }

    public function orderRate(DriverOrderRateDatatable $dataTable)
    {

        return $dataTable->render($this->view['orderRate'], [
            'breadcrumbs' => $this->crums->add(__('driver')),
            'actionMultiple' => $this->getDriverOrderRateActionMultiple(),
        ]);
    }

    public function pendingVerification(PendingDriverDataTable $dataTable)
    {
        $actionMultiple = $this->getPendingDriverActionMultiple();
        return $dataTable->render($this->view['pending'], [
            'breadcrumbs' => $this->crums->add(__('driverNew')),
            'actionMultiple' => $actionMultiple,
        ]);
    }

    public function create(): Factory|View|Application
    {
        $areas = $this->areaRepository->getAll();
        $banks = $this->bankRepository->getAll();
        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'roles' => UserRoles::asSelectArray(),
            'areas' => $areas,
            'banks' => $banks,
            'type' => VehicleType::asSelectArray(),
            'order_accepted' => DriverStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('driver'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(DriverRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);


    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $driver = $this->repository->findOrFail($id);
        $areas = $this->areaRepository->getAll();
        $weightRanges = $this->weightRangeRepository->getBy([
            'status' => DefaultStatus::Published
        ]);
        $banks = $this->bankRepository->getAll();
        $reviews = $this->reviewService->getReviews($id);

        return view(
            $this->view['edit'],
            [
                'gender' => Gender::asSelectArray(),
                'order_status' => DriverOrderStatus::asSelectArray(),
                'status' => UserStatus::asSelectArray(),
                'verified' => VerificationStatus::asSelectArray(),
                'type' => VehicleType::asSelectArray(),
                'active' => OpenStatus::asSelectArray(),
                'areas' => $areas,
                'driver' => $driver,
                'banks' => $banks,
                'weightRanges' => $weightRanges,
                'breadcrumbs' => $this->crums->add(__('driver'), route($this->route['index']))->add(__('edit')),
                'reviews' => $reviews,
            ],
        );
    }

    public function reviews(ReviewDataTable $dataTable, $id)
    {
        return $dataTable->render($this->view['reviews'], [
            'breadcrumbs' => $this->crums->add(__('driver'), route($this->route['index']))->add(__('Đánh giá tài xế'))
        ]);
    }

    public function deleteReview($id): RedirectResponse
    {
        $this->reviewService->delete($id);
        return redirect()->back()->with('success', __('notifySuccess'));
    }

    public function update(DriverRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        return $this->handleUpdateResponse($response);
    }

    public function delete($id): RedirectResponse
    {
        $driver = $this->repository->findOrFail($id);
        $userId = $driver->user_id;
        $user = $this->repository->getUser($userId);
        $user->update(['status' => UserStatus::Inactive->value]);
        return $this->handleUpdateResponse($user);
    }

    public function approve($id): RedirectResponse
    {
        $response = $this->service->approve($id);
        return $this->handleUpdateResponse($response);
    }

    public function reject($id): RedirectResponse
    {
        $response = $this->service->reject($id);
        return $this->handleUpdateResponse($response);
    }

    public function discount(DriverDiscountDataTable $dataTable)
    {
        return $dataTable->render($this->view['discount'], [
            'breadcrumbs' => $this->crums->add(__('driverNew'))
        ]);
    }

    public function orders(OrderByDriverDatatable $dataTable)
    {
        return $dataTable->render($this->view['orders'], [
            'breadcrumbs' => $this->crums->add(__('Tài xế')),
        ]);
    }

    public function delete_order($id)
    {
        $order = $this->orderRepository->findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', __('notifySuccess'));
    }

    protected function getPendingDriverActionMultiple(): array
    {
        return [
            VerificationStatus::Verified->value => VerificationStatus::Verified->description(),
            VerificationStatus::Cancelled->value => VerificationStatus::Cancelled->description(),
        ];
    }

    public function actionPendingDriverMultipleRecode(Request $request): RedirectResponse
    {
        $boolean = $this->service->pendingDriverMultipleRecode($request);
        if ($boolean) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    protected function getDriverActionMultiple(): array
    {
        return [
            DriverStatus::PendingConfirmation->value => DriverStatus::PendingConfirmation->description(),
            DriverStatus::Lock->value => DriverStatus::Lock->description(),
            DriverStatus::Active->value => DriverStatus::Active->description(),
            DriverStatus::Inactive->value => DriverStatus::Inactive->description(),
        ];
    }

    public function actionDriverMultipleRecode(Request $request): RedirectResponse
    {
        $boolean = $this->service->actionDriverMultipleRecode($request);
        if ($boolean) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    protected function getDriverOrderRateActionMultiple(): array
    {
        return [
            DriverStatus::Active->value => DriverStatus::Active->description(),
            DriverStatus::Lock->value => DriverStatus::Lock->description(),
            DriverStatus::Inactive->value => DriverStatus::Inactive->description(),
        ];
    }
}

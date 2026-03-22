<?php

namespace App\Admin\Http\Controllers\User;

use App\Admin\DataTables\User\UserOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\User\UserRequest;
use App\Admin\Repositories\Bank\BankRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\User\UserServiceInterface;
use App\Admin\DataTables\User\UserDataTable;
use App\Enums\OpenStatus;
use App\Enums\Vehicle\VehicleType;
use App\Traits\ResponseController;
use Exception;
use App\Enums\User\{CostStatus, DiscountSortStatus, DistanceStatus, Gender, RatingSortStatus, TimeStatus, UserStatus};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseController;

    protected BankRepositoryInterface $bankRepository;

    public function __construct(
        UserRepositoryInterface $repository,
        BankRepositoryInterface $bankRepository,
        UserServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->bankRepository = $bankRepository;

        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'edit' => 'admin.users.edit',
            'history' => 'admin.users.order.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'edit' => 'admin.user.edit',
            'delete' => 'admin.user.delete',
            'history' => 'admin.users.history',
        ];
    }

    public function index(UserDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render(
            $this->view['index'],
            [
                'gender' => Gender::asSelectArray(),
                'status' => UserStatus::asSelectArray(),
                'actionMultiple' => $actionMultiple,
                'breadcrumbs' => $this->crums->add(__('user'))
            ]

        );
    }

    public function history(UserOrderDataTable $dataTable)
    {
        return $dataTable->render(
            $this->view['history'],
            [
                'status' => UserStatus::asSelectArray()
            ]
        );

    }

    public function create(): Factory|View|Application
    {
        $roles = $this->repository->getAllRolesByGuardName('web');
        $banks = $this->bankRepository->getAll();

        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'roles' => $roles,
            'banks' => $banks,
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);


    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $instance = $this->repository->findOrFail($id);
        $roles = $this->repository->getAllRolesByGuardName('web');
        $banks = $this->bankRepository->getAll();

        return view(
            $this->view['edit'],
            [
                'user' => $instance,
                'gender' => Gender::asSelectArray(),
                'status' => UserStatus::asSelectArray(),
                'roles' => $roles,
                'banks' => $banks,
                'cost_preferences' => CostStatus::asSelectArray(),
                'car_lives' => TimeStatus::asSelectArray(),
                'rating_preferences' => RatingSortStatus::asSelectArray(),
                'discount_preferences' => DiscountSortStatus::asSelectArray(),
                'distance_preferences' => DistanceStatus::asSelectArray(),
                'vehicle_types' => VehicleType::asSelectArray(),
                'active' => OpenStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('user'), route($this->route['index']))->add(__('edit'))

            ],
        );

    }

    public function update(UserRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);


    }

    public function delete($id): RedirectResponse
    {
        $response = $this->repository->findOrFail($id);
        $response->update(['status' => UserStatus::Inactive->value]);
        return $this->handleUpdateResponse($response);
    }

    protected function getActionMultiple(): array
    {
        return [
            'active' => UserStatus::Active->description(),
            'inactive' => UserStatus::Inactive->description(),
            'lock' => UserStatus::Lock->description()
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

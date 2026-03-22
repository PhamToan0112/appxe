<?php

namespace App\Admin\Http\Controllers\Address;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Address\AddressRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Services\Address\AddressServiceInterface;
use App\Enums\Address\AddressType;
use App\Traits\ResponseController;
use App\Admin\Http\Requests\Address\AddressRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{
    use ResponseController;
    protected DriverRepositoryInterface $driverRepository;
    public function __construct(
        AddressRepositoryInterface $repository,
        AddressServiceInterface $service,
        DriverRepositoryInterface $driverRepository

    ) {
        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
        $this->driverRepository = $driverRepository;
    }
    public function getView(): array
    {

        return [
            'index' => 'admin.address.index',
            'create' => 'admin.address.create',
            'edit' => 'admin.address.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'create' => 'admin.address.create',
            'edit' => 'admin.address.edit',
            'delete' => 'admin.address.delete',
            'editDriver' => 'admin.driver.edit',
            'editUser' => 'admin.user.edit'
        ];
    }

    /**
     * @throws Exception
     */
    public function create($userId): Factory|View|Application
    {
        $user = $this->repository->getUserById($userId);
        $driver = $user->driver;
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('address')),
            'type' => AddressType::asSelectArray(),
            'user' => $user,
            'driver' => $driver,
        ]);
    }

    public function store(AddressRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);
        return to_route($this->route['edit'], ['id' => $response->id])->with('success', __('notifySuccess'));
    }


    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $address = $this->repository->findOrFail($id);
        $userId = $address->user_id;
        $driver = $this->repository->getDriverByUserId($userId);
        $driverId = $driver ? $driver->id : null;
        return view(
            $this->view['edit'],
            [
                'user_id' => $userId,
                'fullname' => $address->user->fullname,
                'driver_id' => $driverId,
                'name' => $address->name,
                'address' => $address,
                'type' => AddressType::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('address')),
            ],
        );
    }

    public function update(AddressRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);
    }


    /**
     * @throws Exception
     */
    /**
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $address = $this->repository->findOrFail($id);
        $user = $address->user;

        if ($user->driver) {
            $driverId = $user->driver->id;
            $this->service->delete($id);

            return to_route($this->route['editDriver'], ['id' => $driverId])
                ->with('success', __('notifySuccess'));
        }

        $this->service->delete($id);
        return to_route($this->route['editUser'], ['id' => $address->user_id])
                ->with('success', __('notifySuccess'));
    }
}

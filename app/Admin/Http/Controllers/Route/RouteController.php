<?php

namespace App\Admin\Http\Controllers\Route;

use App\Admin\DataTables\Routes\DriverRoutesDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Route\RouteRequest;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Route\RouteRepositoryInterface;
use App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface;
use App\Admin\Services\Route\RouteServiceInterface;
use App\Enums\Area\AreaStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    use ResponseController;

    protected DriverRepositoryInterface $driverRepository;
    protected RouteVariantRepositoryInterface $routeVariantRepository;

    public function __construct(
        RouteRepositoryInterface $repository,
        RouteServiceInterface $service,
        DriverRepositoryInterface $driverRepository,
        RouteVariantRepositoryInterface $routeVariantRepository
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->routeVariantRepository = $routeVariantRepository;
        $this->driverRepository = $driverRepository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.routes.index',
            'create' => 'admin.routes.create',
            'edit' => 'admin.routes.edit',
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.driver.route.index',
            'create' => 'admin.driver.route.create',
            'edit' => 'admin.driver.route.edit',
            'delete' => 'admin.driver.route.delete',
            'editDriver' => 'admin.driver.edit'
        ];
    }

    public function index(DriverRoutesDataTable $dataTable)
    {
        return $dataTable->render($this->view['index']);
    }

    /**
     * @throws Exception
     */
    public function create($driverId): Factory|View|Application
    {
        $driver = $this->driverRepository->findOrFail($driverId);
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('route_settings')),
            'status' => AreaStatus::asSelectArray(),
            'driver' => $driver,

        ]);
    }

    public function store(RouteRequest $request): RedirectResponse
    {
        try {
            $response = $this->service->store($request);
            return to_route($this->route['edit'], ['id' => $response->id])
                ->with('success', __('notifySuccess'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */


    public function edit($id): Factory|View|Application
    {
        $instance = $this->repository->findOrFail($id);
        $variants = $this->routeVariantRepository->getBy(['route_id' => $instance->id]);
        return view(
            $this->view['edit'],
            [
                'instance' => $instance,
                'variants' => $variants,
                'driver' => $instance->driver,
                'status' => AreaStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('edit_route_settings')),
            ],
        );
    }

    public function update(RouteRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);

    }

    /**
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $this->service->delete($id);

        if (request()->get('driver_id')) {
            return redirect()->route('admin.driver.edit', request()->get('driver_id'))->with('success', __('notifySuccess'));
        }

        return redirect()->back()->with('success', __('notifySuccess'));
    }

    public function actionMultipleRecord(Request $request)
    {
        $boolean = $this->service->actionMultipleRecord($request);
        if ($boolean) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

}
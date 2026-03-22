<?php

namespace App\Admin\Http\Controllers\WeightRange;

use App\Admin\DataTables\WeightRange\WeightRangeDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\WeighRange\WeightRangeRequest;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Services\WeightRange\WeightRangeServiceInterface;
use App\Enums\DefaultStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WeightRangeController extends Controller
{
    use ResponseController;

    public function __construct(
        WeightRangeRepositoryInterface $repository,
        WeightRangeServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.weight_ranges.index',
            'create' => 'admin.weight_ranges.create',
            'edit' => 'admin.weight_ranges.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.weightRange.index',
            'create' => 'admin.weightRange.create',
            'edit' => 'admin.weightRange.edit',
            'delete' => 'admin.weightRange.delete'
        ];
    }

    public function index(WeightRangeDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('weight_ranges'))
        ]);
    }

    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('weight_ranges'),
                route($this->route['index']))->add(__('add')),
            'status' => DefaultStatus::asSelectArray()
        ]);
    }

    public function store(WeightRangeRequest $request): RedirectResponse
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

        return view(
            $this->view['edit'],
            [
                'instance' => $instance,
                'status' => DefaultStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('weight_ranges'), route($this->route['index']))
                    ->add(__('edit'))
            ],
        );
    }

    public function update(WeightRangeRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);

    }

    public function delete($id): RedirectResponse
    {

        $response = $this->service->delete($id);

        return $this->handleUpdateResponse($response);
    }
}

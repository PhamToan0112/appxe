<?php

namespace App\Admin\Http\Controllers\Category;

use App\Admin\DataTables\Category\CategoryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Category\CategoryRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Category\CategoryServiceInterface;
use App\Enums\ActiveStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    use ResponseController;

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategoryServiceInterface $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.category.index',
            'create' => 'admin.category.create',
            'edit' => 'admin.category.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.category.index',
            'create' => 'admin.category.create',
            'edit' => 'admin.category.edit',
            'delete' => 'admin.category.delete'
        ];
    }
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('category'))
        ]);
    }

    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('category'),
                route($this->route['index'])
            )->add(__('add')),
            'status' => ActiveStatus::asSelectArray()
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $category = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'category' => $category,
                'status' => ActiveStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('category'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(CategoryRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        return $this->handleUpdateResponse($response);
    }

    public function delete($id): RedirectResponse
    {

        $response = $this->repository->findOrFail($id);
        $response->update(['status' => ActiveStatus::Deleted->value]);
        return $this->handleUpdateResponse($response);
    }
}

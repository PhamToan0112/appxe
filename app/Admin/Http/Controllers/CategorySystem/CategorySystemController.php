<?php

namespace App\Admin\Http\Controllers\CategorySystem;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\CategorySystem\CategorySystemRequest;
use App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Admin\Services\CategorySystem\CategorySystemServiceInterface;
use App\Admin\DataTables\CategorySystem\CategorySystemDataTable;
use App\Enums\ActiveStatus;

class CategorySystemController extends Controller
{
    public function __construct(
        CategorySystemRepositoryInterface $repository,
        CategorySystemServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.category_systems.index',
            'create' => 'admin.category_systems.create',
            'edit' => 'admin.category_systems.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.category_system.index',
            'create' => 'admin.category_system.create',
            'edit' => 'admin.category_system.edit',
            'delete' => 'admin.category_system.delete'
        ];
    }
    public function index(CategorySystemDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'],
        [
            'breadcrumbs' => $this->crums->add(__('system_service'))
        ]
    );
    }

    public function create()
    {
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('system_service'), route($this->route['index']))->add(__('add'))
        ]); 
    }


    public function store(CategorySystemRequest $request)
    {
        $response = $this->service->store($request);
        if ($response) {
            return to_route($this->route['edit'], $response)->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('system_service'))->withInput();
    }

    public function edit($id)
    {

        $response = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'category_system' => $response,
                'status' => ActiveStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('system_service'), route($this->route['index']))->add(__('edit'))

            ]
        );

    }

    public function update(CategorySystemRequest $request)
    {

        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));

    }

    public function delete($id)
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }
}
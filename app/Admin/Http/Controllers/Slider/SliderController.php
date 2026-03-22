<?php

namespace App\Admin\Http\Controllers\Slider;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Slider\SliderRequest;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Services\Slider\SliderServiceInterface;
use App\Admin\DataTables\Slider\SliderDataTable;
use App\Enums\Slider\SliderStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SliderController extends Controller
{
    public function __construct(
        SliderRepositoryInterface $repository,
        SliderServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;


        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.sliders.index',
            'create' => 'admin.sliders.create',
            'edit' => 'admin.sliders.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.slider.index',
            'create' => 'admin.slider.create',
            'edit' => 'admin.slider.edit',
            'delete' => 'admin.slider.delete'
        ];
    }
    public function index(SliderDataTable $dataTable){
        return $dataTable->render($this->view['index'],
            [
                'status' => SliderStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('slider'))
            ]
        );
    }

    public function create(): Factory|View|Application
    {

        return view($this->view['create'],
            [
                'status' => SliderStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('slider'), route($this->route['index']))->add(__('add'))
            ]
        );
    }

    public function store(SliderRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);
        if($response){
            return to_route($this->route['edit'], $response->id);
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $response = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'slider' => $response,
                'status' => SliderStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('post_categories'), route($this->route['index']))->add(__('edit'))
            ]
        );

    }

    public function update(SliderRequest $request): RedirectResponse
    {

        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));

    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }
}

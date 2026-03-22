<?php

namespace App\Admin\Http\Controllers\Holiday;

use App\Admin\DataTables\Holiday\HolidayDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Holiday\HolidayRequest;
use App\Admin\Repositories\Holiday\HolidayRepositoryInterface;
use App\Admin\Services\Holiday\HolidayServiceInterface;
use App\Enums\DefaultStatus;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HolidayController extends Controller
{
    use ResponseController;

    protected $repository;

    public function __construct(
        HolidayRepositoryInterface $repository,
        HolidayServiceInterface $service,
    ) {

        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.holidays.index',
            'create' => 'admin.holidays.create',
            'edit' => 'admin.holidays.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.holiday.index',
            'create' => 'admin.holiday.create',
            'edit' => 'admin.holiday.edit',
        ];
    }

    public function index(HolidayDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách ngày lễ')),
            'actionMultiple' => $actionMultiple,
        ]);
    }


    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('holiday')),
            'status' => DefaultStatus::asSelectArray(),
        ]);
    }


    public function store(HolidayRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);

        return to_route($this->route['edit'], ['id' => $response->id])->with('success', __('notifySuccess'));

    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $holiday = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'holiday' => $holiday,
                'breadcrumbs' => $this->crums->add(
                    __('DS ngày lễ'),
                    route($this->route['index'])
                )->add(__('edit')),
                'status' => DefaultStatus::asSelectArray()
            ],
        );
    }

    public function update(HolidayRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);

    }

    public function delete($id): RedirectResponse
    {
        $this->repository->delete($id);

        return redirect()->back()->with('success', __('notifySuccess'));
    }

    protected function getActionMultiple(): array
    {   
        return [
            'published' => DefaultStatus::Published->description(),
            'draft' => DefaultStatus::Draft->description(),
            'deleted' => DefaultStatus::Deleted->description(),
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
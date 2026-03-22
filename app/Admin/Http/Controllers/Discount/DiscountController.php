<?php

namespace App\Admin\Http\Controllers\Discount;

use App\Admin\DataTables\Discount\DiscountApplyDataTable;
use App\Admin\DataTables\Discount\DiscountDataTable;
use App\Admin\DataTables\Discount\DiscountExpiredDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Discount\DiscountRequest;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Admin\Services\Discount\DiscountServiceInterface;
use App\Enums\Discount\DiscountOption;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    use ResponseController;

    protected $repository;

    public function __construct(
        DiscountRepositoryInterface $repository,
        DiscountServiceInterface $service,
    ) {

        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.discounts.index',
            'create' => 'admin.discounts.create',
            'edit' => 'admin.discounts.edit',
            'apply' => 'admin.discounts.apply.index',
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.discount.index',
            'create' => 'admin.discount.create',
            'edit' => 'admin.discount.edit',
        ];
    }

    public function index(DiscountDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render(
            $this->view['index'],
            [
                'breadcrumbs' => $this->crums->add(__('listDiscount')),
                'actionMultiple' => $actionMultiple,
            ],
        );
    }

    public function apply(DiscountApplyDataTable $dataTable)
    {
        return $dataTable->render(
            $this->view['apply'],
            [
                'breadcrumbs' => $this->crums->add(__('listDiscount')),
            ],
        );
    }


    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('listDiscount'),
                route($this->route['index'])
            )->add(__('add')),
            'types' => DiscountType::asSelectArray(),
            'options' => DiscountOption::asSelectArray(),
        ]);
    }


    public function store(DiscountRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);

    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $discount = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'discount' => $discount,
                'types' => DiscountType::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Trang chủ'),
                    route($this->route['index'])
                )->add(__('edit')),
                'status' => DiscountStatus::asSelectArray(),
                'options' => DiscountOption::asSelectArray(),
            ],
        );
    }

    public function update(DiscountRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);

    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return redirect()->back()->with('success', __('notifySuccess'));
    }

    public function expired(DiscountExpiredDataTable $datatable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $datatable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Mã giảm giá hết hạn')),
            'actionMultiple' => $actionMultiple,
        ]);
    }


    protected function getActionMultiple(): array
    {
        return [
            'published' => 'Hoạt động',
            'inactive' => DiscountStatus::Inactive->description(),
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

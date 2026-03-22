<?php

namespace App\Admin\Http\Controllers\Order;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\OrderMultiPointDetail\OrderMultiPointDetailRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepositoryInterface;
use App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface;
use App\Admin\Services\OrderMultiPointDetail\OrderMultiPointDetailServiceInterface;
use App\Enums\ActiveStatus;
use App\Enums\DefaultStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\OrderMultiPointStatus;
use App\Traits\ResponseController;

class OrderMultiPointDetailController extends Controller
{
    use ResponseController;

    protected $orderMultiPointDetailRepository;
    protected $orderMultiPointDetailService;
    protected $rangeRepository;
    protected $categoryRepository;


    public function __construct(
        OrderMultiPointDetailRepositoryInterface $orderMultiPointDetailRepository,
        OrderMultiPointDetailServiceInterface $orderMultiPointDetailService,
        WeightRangeRepositoryInterface $rangeRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct();

        $this->orderMultiPointDetailRepository = $orderMultiPointDetailRepository;
        $this->orderMultiPointDetailService = $orderMultiPointDetailService;
        $this->rangeRepository = $rangeRepository;
        $this->categoryRepository = $categoryRepository;

    }

    public function getView(): array
    {
        return [
            'edit' => 'admin.order_multi_point_detail.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'editCMulti' => 'admin.cMulti.edit',
            'edit' => 'admin.multiPointDetail.edit',
        ];
    }

    public function edit($id)
    {
        $orderMultiPointDetail = $this->orderMultiPointDetailRepository->findOrFail($id);
        $weightRanges = $this->rangeRepository->getBy(['status' => DefaultStatus::Published]);
        $categories = $this->categoryRepository->getBy(['status' => ActiveStatus::Active]);
        return view($this->view['edit'], [
            'orderMultiPointDetail' => $orderMultiPointDetail,
            'weightRanges' => $weightRanges,
            'categories' => $categories,
            'collection_from_sender_status' => OpenStatus::asSelectArray(),
            'delivery_status' => OrderMultiPointStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('Chi tiết địa điểm giao'),
                route($this->route['editCMulti'], $orderMultiPointDetail->order_id)
            )->add(__('edit'))
        ]);
    }

    public function update(OrderMultiPointDetailRequest $request)
    {
        $this->orderMultiPointDetailService->update($request);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
}

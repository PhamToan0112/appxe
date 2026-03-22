<?php

namespace App\Admin\DataTables\Shipment;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Shipment\ShipmentRepositoryInterface;
use App\Enums\DeleteStatus;
use App\Enums\Shipment\ShipmentStatus;
use App\Enums\Order\ShippingProgressStatus;


class ShipmentDataTable extends BaseDataTable
{


    protected $nameTable = 'shipmentTable';


    public function __construct(
        ShipmentRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'id' => 'admin.shipment.datatable.id',
            'action' => 'admin.shipment.datatable.action',
            'user_id' => 'admin.shipment.datatable.user_id',
            'weight_range_id' => 'admin.shipment.datatable.weight_range_id',
            'collection_from_sender_status' => 'admin.shipment.datatable.collection_from_sender_status',
            'advance_payment_status' => 'admin.shipment.datatable.advance_payment_status',
            'shipment_status' => 'admin.shipment.datatable.shipment_status',
            'is_deleted' => 'admin.shipment.datatable.is_deleted',
            'shipping_progress_status' => 'admin.shipment.datatable.shipping_progress_status',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];

        $this->columnSearchSelect = [
            [
                'column' => 10,
                'data' => ShipmentStatus::asSelectArray()
            ],
            [
                'column' => 11,
                'data' => DeleteStatus::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([
            ['shipment_status', 'IN', [ShipmentStatus::Draft, ShipmentStatus::Preparing, ShipmentStatus::Ordered]],
            ['is_deleted', '=', DeleteStatus::NotDeleted]
        ])->with(['user', 'weightRange']);
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.shipment', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'user_id' => function ($shipment) {
                return view($this->view['user_id'], [
                    'user' => $shipment->user
                ])->render();
            },
            'weight_range_id' => function ($shipment) {
                return view($this->view['weight_range_id'], [
                    'weightRange' => $shipment->weightRange
                ])->render();
            },
            'collection_from_sender_status' => $this->view['collection_from_sender_status'],
            'advance_payment_status' => $this->view['advance_payment_status'],
            'collect_on_delivery_amount' => '{{format_price($collect_on_delivery_amount)}}',
            'shipment_status' => $this->view['shipment_status'],
            'is_deleted' => $this->view['is_deleted'],
            'id' => $this->view['id'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'user_id' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', "%$keyword%");
                });
            },
            'weight_range_id' => function ($query, $keyword) {
                $query->whereHas('weightRange', function ($subQuery) use ($keyword) {
                    $subQuery->where('min_weight', 'like', "%$keyword%")
                        ->orWhere('max_weight', 'like', "%$keyword%");
                });
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'action',
            'shipment_status',
            'collection_from_sender_status',
            'advance_payment_status',
            'collection_on_devivery_amount',
            'weight_range_id',
            'is_deleted',
            'id',
            'user_id',
        ];
    }
}
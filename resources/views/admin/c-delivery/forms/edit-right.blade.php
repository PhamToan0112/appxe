@php use App\Enums\OpenStatus; @endphp
<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings"></i>
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="w-100 d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"
                    class="flex-column gap-1 text-wrap p-2 flex-grow-1" />
                <x-link :href="route('admin.cDelivery.index')" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings-cancel"></i>
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$order->status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings-cancel"></i>
            @lang('collection_from_sender_status')
        </div>
        <div class="card-body p-2">
            <x-select name="collection_from_sender_status" :required="true">
                @foreach ($collection_from_sender_status as $key => $value)
                    <x-select-option :option="$shipment->collection_from_sender_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-user-dollar"></i>
            @lang('payment_role')
        </div>
        <div class="card-body p-2">
            <x-select name="payment_role" :required="true">
                @foreach ($payment_role as $key => $value)
                    <x-select-option :option="$order->payment_role->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings-cancel"></i>
            @lang('delivery_status')
        </div>
        <div class="card-body p-2">
            <x-select name="delivery_status" :required="true">
                @foreach ($delivery_status as $key => $value)
                    <x-select-option :option="$order->delivery_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-user-dollar"></i>
            @lang('advance_payment_status')
        </div>
        <div class="card-body p-2">
            <x-select name="advance_payment_status" :required="true">
                @foreach ($advance_payment_status as $key => $value)
                    <x-select-option :option="$order->advance_payment_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    <!-- avatar -->
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header gap-1">
                <i class="ti ti-photo-check"></i>
                @lang('order_confirmation_image')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder name="order_confirmation_image" showImage="order_confirmation_image"
                    class="img-fluid" :value="$order->order_confirmation_image" />
            </div>
        </div>
    </div>

    <!-- return_image -->
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header gap-1">
                <i class="ti ti-photo-check"></i>
                @lang('return_image')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder name="return_image" showImage="return_image" class="img-fluid"
                    :value="$order->return_image" />
            </div>
        </div>
    </div>

    <!--Vehicle -->
    <div class="card mb-3">
        <div class="card mb3">
            <div class="card-header gap-1">
                <i class="ti ti-motorbike"></i>
                <h4 class="m-0">Phương tiện của tài xế</h4>
            </div>

            @if (isset($vehicle) && $vehicle->isNotEmpty())
                @foreach ($vehicle as $item)
                    <div class="card-body">
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label">@lang('Mã xe'):</label>
                            <div class="col-sm-7 d-flex align-items-center">
                                <x-link :href="route('admin.vehicle.edit', $item->id)" :title="$item->code" />
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label">@lang('Tên xe'):</label>
                            <div class="col-sm-7">
                                <span class="form-control-plaintext">{{ $item->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label">@lang('license_plate'):</label>
                            <div class="col-sm-7">
                                <span class="form-control-plaintext">{{ $item->license_plate }}</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label">@lang('Dòng xe'):</label>
                            <div class="col-sm-7">
                                <span class="form-control-plaintext">{{ $item->vehicleLine->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

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
                <x-link :href="route('admin.cMulti.index')" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
        </div>
    </div>
    {{-- status --}}
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

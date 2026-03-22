
<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Đăng ký') }}</h4>
    </div>
    <div class="row card-body">
        <x-link :href="route('admin.area.create')" class="">
            <span class="ms-1 my-2 float-end">@lang('Thêm mới')</span>
        </x-link>
        @foreach ($driver->vehicles as $vehicle)
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">{{ $vehicle->name }}</span>
                            <x-link :href="route('admin.vehicle.edit',$vehicle->id)" >
                                <span class="">({{ $vehicle->license_plate }})</span>
                            </x-link>
                        </div>
                        {!! statusBadge(App\Enums\Vehicle\VehicleStatus::from($vehicle->status->value)) !!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>


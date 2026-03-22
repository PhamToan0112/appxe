@php use App\Enums\Service\ServiceStatus; @endphp
<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Cấu hình') }}</h4>
    </div>
    <div class="row card-body">
        {{--  current-address --}}
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-end-address :label="trans('pickup_address')" name="end_address" :placeholder="trans('pickAddress')" :value="$driver->current_address" />
                <x-input type="hidden" name="end_lat" :value="$driver->current_lat" />
                <x-input type="hidden" name="end_lng" :value="$driver->current_lng" />
            </div>
        </div>

        {{--  service_start_time --}}
{{--        <div class="col-6 time-pick-flex">--}}
{{--            <div class="mb-3">--}}
{{--                <label for="service_start_time">--}}

{{--                    {{ __('service_start_time') }}</label>--}}
{{--                <x-input type="time" :value="$driver->service_start_time" name="service_start_time" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        --}}{{--  service_end_time --}}
{{--        <div class="col-6 time-pick-flex">--}}
{{--            <div class="mb-3">--}}
{{--                <label for="service_end_time">--}}
{{--                    {{ __('service_end_time') }}</label>--}}
{{--                <x-input type="time" :value="$driver->service_end_time" name="service_end_time" />--}}
{{--            </div>--}}
{{--        </div>--}}

        {{-- min_earning --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">
                    {{ __('Giá thu hộ thấp nhất') }}:</label>
                <x-input-price name="min_earning" id="min_earning" :value="$driver->min_earning" :required="true"
                    :placeholder="__('Giá thu hộ thấp nhất')" />
            </div>
        </div>
        {{-- max_earning --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá thu hộ cao nhất') }}:</label>
                <x-input-price name="max_earning" id="max_earning" :value="$driver->max_earning" :required="true"
                    :placeholder="__('Giá thu hộ cao nhất')" />
            </div>
        </div>
        {{-- C-Ride --}}
        @include('admin.drivers.partials.c-ride')

        {{-- C-Car --}}
        @include('admin.drivers.partials.c-car')

        {{-- C-Delivery now --}}
        @include('admin.drivers.partials.c-delivery-now')

        {{-- C-Delivery later --}}
        @include('admin.drivers.partials.c-delivery-later')

        {{-- C-Intercity --}}
        @include('admin.drivers.partials.c-intercity')


        {{-- trips --}}
        <div class="col-md-12 col-sm-12">
            <div class="my-3">
                <label class="control-label">{{ __('Danh sách chuyến đi') }}:</label>
                <x-link :href="route('admin.driver.route.create', $driver->id)">
                    <span class="ms-1 my-2 float-end">@lang('Thêm mới')</span>
                </x-link>
                @foreach ($driver->routes as $item)
                    <div class="card mb-2 w-full">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $item->name }}</span>
                                    <x-link :href="route('admin.driver.route.edit', [
                                        'id' => $item->id,
                                        'driver_id' => $driver->id,
                                    ])">
                                        <span>Chi tiết</span>
                                    </x-link>
                                    <div class="mt-3">
                                        <p>Từ: {{ $item->start_address }}</p>
                                        <span>Đến: {{ $item->end_address }}</span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-3 flex-1">
                                    <div class="">
                                        <span>Giá vé:</span>
                                        <x-input-price name="price" id="price" disabled :value="$item->price"
                                            :required="true" :placeholder="__('Giá vé ')" />

                                    </div>

                                    <div class="">
                                        <span>Khứ hồi:</span>
                                        <x-input-price name="price" id="price" disabled :value="$item->return_price"
                                            :required="true" :placeholder="__('Giá vé ')" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>


    </div>
</div>

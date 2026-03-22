@php use Carbon\Carbon; @endphp

<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h3>Tài xế: {{ $driver->user->fullname }}</h3>
        </div>
        <div class="row card-body">
            {{--  start_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-map"></i>
                    <label class="control-label">@lang('start_address')</label>
                    <x-input name="start_address" :value="$instance->start_address" :placeholder="__('start_address')" />
                </div>
            </div>
            {{--  end_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-map"></i>
                    <label class="control-label">@lang('end_address')</label>
                    <x-input name="end_address" :value="$instance->end_address" :placeholder="__('end_address')" />
                </div>
            </div>

            {{-- price --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <i class="ti ti-cash"></i>
                        {{ __('Giá vé của tuyến đường') }}:</label>
                    <x-input-price name="price" id="price" :value="$instance->price" :required="true"
                        :placeholder="__('Giá vé của tuyến đường')" />
                </div>
            </div>
            {{-- return_price --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <i class="ti ti-cash"></i>
                        {{ __('return_price') }}:</label>
                    <x-input-price name="return_price" id="return_price" :value="$instance->return_price" :required="true"
                        :placeholder="__('return_price')" />
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">@lang('Danh sách phục vụ')</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Điểm bắt đầu</th>
                        <th>Điểm đến</th>
                        <th>Giờ khởi hành</th>
                        <th>Giá vé</th>
                        <th>Loại chuyến đi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($variants as $variant)
                        <tr>
                            <td>{{ $variant->start_address }}</td>
                            <td>{{ $variant->end_address }}</td>
                            <td>{{ $variant->departure_time }}</td>
                            <td>{{ format_price($variant->price) }}</td>
                            <td>
                                <span
                                    @class([
                                        'badge',
                                        \App\Enums\Order\TripType::from($variant->trip_type->value)->badge(),
                                    ])>{{ \App\Enums\Order\TripType::getDescription($variant->trip_type->value) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>

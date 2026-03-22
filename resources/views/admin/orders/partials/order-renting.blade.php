<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">{{ __('Thông tin đơn hàng #:id', ['id' => $order->id]) }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-12 col-md-6">
                <h3>{{ __('Thông tin chung') }}</h3>
                <div class="mb-3">
                    <label for="">{{ __('Khách hàng') }}</label>
                    <x-select class="select2-bs5-ajax" name="order[user_id]" :required="true">
                        <x-select-option :option="$order->user_id" :value="$order->user_id" :title="optional($order->user)->fullname"/>
                    </x-select>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Trạng thái') }}:</label>
                    <x-select name="order[status]" :required="true">
                        @foreach ($status as $key => $value)
                            <x-select-option :option="$order->status->value" :value="$key" :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Địa chỉ bắt đầu') }}:</label>
                    <x-input class="form-control" :value="$order->start_address" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Địa chỉ kết thúc') }}:</label>
                    <x-input class="form-control" :value="$order->end_address" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Ngày tạo') }}:</label>
                    <x-input class="form-control" :value="format_date($order->created_at)" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Phương thức thanh toán') }}:</label>
                    <x-input class="form-control" :value="App\Enums\Payment\PaymentMethod::getDescription($order->payment_method->value)" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Tổng tiền') }}:</label>
                    <x-input class="form-control" :value="format_price($order->total)" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Ghi chú') }}:</label>
                    <textarea name="order[note]" class="form-control">{{ $order->note }}</textarea>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h3>{{ __('Thông tin phương tiện') }}</h3>
                <div class="mb-3">
                    <label for="">{{ __('Tên phương tiện') }}:</label>
                    <x-input class="form-control" :value="$order->vehicle->name" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Màu') }}:</label>
                    <x-input class="form-control" :value="$order->vehicle->color" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Số chỗ ngồi') }}:</label>
                    <x-input class="form-control" :value="$order->vehicle->seat_number" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Thương hiệu') }}:</label>
                    <x-input class="form-control" :value="$order->vehicle->vehicle_company" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Giá thuê') }}:</label>
                    <x-input class="form-control" :value="format_price($order->vehicle->price)" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Biển số xe') }}:</label>
                    <x-input class="form-control" :value="$order->vehicle->license_plate" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Loại xe') }}:</label>
                    <x-input class="form-control" :value="App\Enums\Vehicle\VehicleType::getDescription($order->vehicle->type->value)" :readonly="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Trạng thái xe') }}:</label>
                    <x-input class="form-control" :value="App\Enums\Vehicle\VehicleStatus::getDescription($order->vehicle->status->value)" :readonly="true"/>
                </div>
            </div>
        </div>
    </div>
</div>

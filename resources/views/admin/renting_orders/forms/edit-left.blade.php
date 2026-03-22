<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">{{ __('Thông tin đơn hàng #:id', ['id' => $order->id]) }}</h2>
        </div>
        <div class="row card-body">
            <div class="col-12">
                <h3>{{ __('Thông tin chung') }}</h3>
                <div class="mb-3">
                    <label for="">{{ __('Khách hàng') }}</label>
                    <x-select
                        name="user_id"
                        class="select2-bs5-ajax"
                        :data-url="route('admin.search.select.user')"
                        id="user_id"
                        :required="true">
                        <x-select-option :option="$order->user_id"
                            :value="$order->user_id"
                            :title="$order->user->fullname .' - '. $order->user->phone"/>
                    </x-select>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Phương tiện') }}</label>
                    <x-select name="vehicle_id"
                        class="select2-bs5-ajax"
                        :data-url="route('admin.search.select.vehicle')"
                        id="vehicle_id"
                        :required="true">
                        <x-select-option :option="$order->vehicle_id"
                            :value="$order->vehicle_id"
                            :title="$order->vehicle->name .' - '. $order->vehicle->color . ' - ' . $order->vehicle->price . '$'"/>
                    </x-select>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Ngày bắt đầu') }}:</label>
                    <x-input id="start_date" :value="format_date($order->start_date)" name="start_date" type="date" class="form-control" :required="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Ngày kết thúc') }}:</label>
                    <x-input id="end_date" :value="format_date($order->end_date)" name="end_date" type="date" class="form-control" :required="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Phương thức thanh toán') }}:</label>
                    <x-select name="payment_method" :required="true">
                        @foreach ($payment_methods as $key => $value)
                            <x-select-option :option="$order->payment_method->value" :value="$key" :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Tổng tiền') }}:</label>
                    <x-input id="total" :value="format_price($order->total)" name="total" class="form-control" :readonly="true" :required="true"/>
                </div>
                <div class="mb-3">
                    <label for="">{{ __('Ghi chú') }}:</label>
                    <textarea name="note" class="form-control">{{ $order->note }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

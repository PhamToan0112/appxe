@php
    use App\Enums\Order\DeliveryStatus;
    use Carbon\Carbon;
@endphp
<style>
    .hidden {
        display: none !important;
    }

    .shipment-card {
        background: #ededed;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
        margin-bottom: 20px;
    }

    .shipment-card-header {
        background-color: #ededed;
        color: #333;
        padding: 10px 15px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .shipment-card .list-group-item {
        border: none;
        padding: 10px 20px;
    }

    .shipment-card .list-group-item:not(:last-child) {
        border-bottom: 1px solid #e0e0e0;
    }

    .shipment-card a {
        color: #007bff;
        text-decoration: none;
    }

    .shipment-card a:hover {
        text-decoration: underline;
    }
</style>
<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- code -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <i class="ti ti-brand-codesandbox"></i>
                    <label class="control-label">@lang('code')</label>
                    <x-input disabled name="code" :value="$order->code" :required="true" :placeholder="__('code')" />
                </div>
            </div>

            <!-- created_at -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <i class="ti ti-calendar"></i>
                    <label class="control-label">@lang('created_at'):</label>
                    <x-input type="date" disabled name="created_at" :value="isset($order->created_at) ? format_date($order->created_at, 'Y-m-d') : null" required="true" />
                </div>
            </div>


            {{-- user  --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-plus"></i>
                <label class="control-label">@lang('customer'):</label>
                <x-select class="select2-bs5-ajax" name="user_id" id="user_id" :data-url="route('admin.search.select.user')">
                    <x-select-option :option="$order->user->id" :value="$order->user->id" :title="$order->user->fullname . ' - ' . $order->user->phone" />
                </x-select>
            </div>

            {{-- driver  --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-plus"></i>
                <label class="control-label">@lang('driver'):</label>
                <x-select class="select2-bs5-ajax" name="driver_id" id="driver_id" :data-url="route('admin.search.select.driver')">
                    @if ($order->driver)
                        <x-select-option :option="$order->driver->id" :value="$order->driver->id" :title="$order->driver->user->fullname . ' - ' . $order->driver->user->phone" />
                    @else
                        <x-select-option :option="null" :value="null" :title="__('No driver assigned')" />
                    @endif
                </x-select>
            </div>


            @if ($order->delivery_status === DeliveryStatus::SCHEDULED)
                <!-- Delivery Date -->
                <div class="col-md-6 col-12 mb-3">
                    <i class="ti ti-calendar"></i>
                    <label class="control-label">@lang('delivery_date')</label>
                    <x-input type="date" name="delivery_date" id="delivery_date" :value="isset($order->delivery_date) ? format_date($order->delivery_date, 'Y-m-d') : null" required="true"
                        :placeholder="__('Choose delivery date')" />
                </div>

                <!-- Delivery Time -->
                <div class="col-md-6 col-12 mb-3">
                    <i class="ti ti-calendar-time"></i>
                    <label class="control-label">@lang('delivery_time')</label>
                    <x-input type="time" name="delivery_time" id="delivery_time" :value="isset($order->delivery_time)
                        ? Carbon::createFromFormat('H:i:s', $order->delivery_time)->format('H:i')
                        : null" required="true"
                        :placeholder="__('Choose delivery time')" />
                </div>
            @endif
            <div class="col-md-12 col-12 mb-3">
                <div class="card shipment-card">
                    <div class="card-header shipment-card-header">Chi tiết địa điểm giao</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($order->multiPointDetails as $detail)
                            <li class="list-group-item">
                                <div><i class="ti ti-map-pin" aria-hidden="true"></i> Điểm lấy hàng:
                                    {{ $detail->start_address }}</div>
                                <div><i class="ti ti-map-pin" aria-hidden="true"></i> Điểm giao hàng:
                                    {{ $detail->end_address }}</div>
                                <div><i class="ti ti-scale" aria-hidden="true"></i> Trọng lượng:
                                    {{ $detail->weightRange ? $detail->weightRange->min_weight . ' kg - ' . $detail->weightRange->max_weight . ' kg' : 'Không rõ' }}
                                </div>
                                <div><i class="ti ti-cash" aria-hidden="true"></i> Số tiền thu hộ:
                                    {{ $detail->collect_on_delivery_amount ? number_format($detail->collect_on_delivery_amount) . ' VND' : 'Không có' }}
                                </div>
                                <div><i class="ti ti-tags" aria-hidden="true"></i> Danh mục:
                                    @if ($detail->categories->isNotEmpty())
                                        {{ $detail->categories->pluck('name')->join(', ') }}
                                    @else
                                        Không có danh mục
                                    @endif
                                </div>
                                <a href="{{ route('admin.multiPointDetail.edit', $detail->id) }}" target="_blank">
                                    <i class="ti ti-arrow-right" aria-hidden="true"></i> Xem chi tiết
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <!-- payment_method -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-credit-card"></i> 
                    <label class="control-label">@lang('payment_method')</label>
                    <x-select name="payment_method" :required="true">
                        @foreach ($payment_method as $key => $value)
                            <x-select-option :option="$order->payment_method->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            <!--platform_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i> 
                    <label class="control-label">@lang('platform_fee')</label>
                    <x-input-price name="platform_fee" id="platform_fee" :value="$order->platform_fee" :required="true"
                        :placeholder="__('platform_fee')" />
                </div>
            </div>
            <!-- high_point_area_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i> 
                    <label class="control-label">@lang('Số tiền phí vùng cao điểm')</label>
                    <x-input-price name="high_point_area_fee"
                                   id="high_point_area_fee"
                                   :value="$order->high_point_area_fee"
                                   :required="true"
                                   :placeholder="__('high_point_area_fee')"/>
                </div>
            </div>
            <!-- holiday_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i> 
                    <label class="control-label">@lang('Số tiền phí ngày lễ')</label>
                    <x-input-price name="holiday_fee"
                                   id="holiday_fee"
                                   :value="$order->holiday_fee"
                                   :required="true"
                                   :placeholder="__('holiday_fee')"/>
                </div>
            </div>
            <!-- night_time_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i> 
                    <label class="control-label">@lang('Số tiền phí giờ đêm')</label>
                    <x-input-price name="night_time_fee"
                                   id="night_time_fee"
                                   :value="$order->night_time_fee"
                                   :required="true"
                                   :placeholder="__('night_time_fee')"/>
                </div>
            </div>
            <!-- total -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-coins"></i> 
                    <label class="control-label">@lang('total')</label>
                    <x-input-price name="total" id="total" :value="$order->total" :required="true"
                        :placeholder="__('total')" />
                </div>
            </div>

        </div>
    </div>
</div>

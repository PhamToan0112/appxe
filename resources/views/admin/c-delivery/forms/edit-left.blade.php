@php
    use App\Enums\Order\DeliveryStatus;
    use Carbon\Carbon;
@endphp
<style>
    .hidden {
        display: none !important;
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

            {{-- driver --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-plus"></i>
                <label class="control-label">@lang('driver'):</label>
                <x-select class="select2-bs5-ajax" name="driver_id" id="driver_id" :data-url="route('admin.search.select.driver')">
                    @if ($order->driver && $order->driver->user)
                        <x-select-option
                            :option="$order->driver->id"
                            :value="$order->driver->id"
                            :title="$order->driver->user->fullname . ' - ' . $order->driver->user->phone"
                        />
                    @else
                        <x-select-option :option="null" :value="null" :title="'No Driver Assigned'" />
                    @endif
                </x-select>
            </div>


            <!-- sender_name -->
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-up"></i>
                <label class="control-label">{{ __('Tên người gửi') }}</label>
                <x-input type="text" name="sender_name" id="sender_name" :value="$shipment->sender_name" required="true"
                    :placeholder="__('Nhập tên người gửi')" />
            </div>

            <!-- sender_phone -->
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-phone-outgoing"></i>
                <label class="control-label">{{ __('Số điện thoại người gửi') }}</label>
                <x-input type="tel" name="sender_phone" id="sender_phone" :value="$shipment->sender_phone" required="true"
                    :placeholder="__('Nhập số điện thoại người gửi')" />
            </div>

            <!-- Recipient Name -->
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-down"></i>
                <label class="control-label">@lang('recipient_name')</label>
                <x-input type="text" name="recipient_name" id="recipient_name" :value="$shipment->recipient_name" required="true"
                    :placeholder="__('Enter recipient name')" />
            </div>

            <!-- Recipient Phone -->
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-phone-incoming"></i>
                <label class="control-label">@lang('recipient_phone')</label>
                <x-input type="tel" name="recipient_phone" id="recipient_phone" :value="$shipment->recipient_phone" required="true"
                    :placeholder="__('Enter recipient phone number')" />
            </div>


            <!-- pickup_address -->
            <div class="col-12 mb-3">
                <div class="col-12 d-flex align-items-center gap-2 position-absolute top-3">
                    <i class="ti ti-map-pin"></i>
                    <label>@lang('Địa chỉ lấy hàng')</label>
                </div>
                <x-input-pick-address :label="false" name="address" :value="$shipment->start_address" :placeholder="trans('pickAddress')"
                    :required="true" />
                <x-input type="hidden" name="lat" :value="$shipment->start_latitude" />
                <x-input type="hidden" name="lng" :value="$shipment->start_longitude" />
            </div>

            {{--  end-address --}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="col-12 d-flex align-items-center gap-2 position-absolute top-3">
                        <i class="ti ti-map-pin"></i>
                        <label>@lang('shipping_address')</label>
                    </div>
                    <x-input-pick-end-address :label="false" name="end_address" :placeholder="trans('pickAddress')"
                        :value="$shipment->end_address" />
                    <x-input type="hidden" name="end_lat" :value="$shipment->end_latitude" />
                    <x-input type="hidden" name="end_lng" :value="$shipment->end_longitude" />
                </div>
            </div>
            <!-- show map -->
            <div id="resultMap" class="w-100 " style="height: 400px"></div>
            <!-- detail map-->
            <div id="directions-panel" class="mb-3"></div>

            @if ($order->delivery_status === DeliveryStatus::SCHEDULED)
                <!-- Delivery Date -->
                <div class="col-md-6 col-12 mb-3">
                    <i class="ti ti-calendar-date"></i>
                    <label class="control-label">@lang('delivery_date')</label>
                    <x-input type="date" name="delivery_date" id="delivery_date" :value="isset($order->delivery_date) ? format_date($order->delivery_date, 'Y-m-d') : null" required="true"
                        :placeholder="__('Choose delivery date')" />
                </div>

                <!-- Delivery Time -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="control-label">@lang('delivery_time')</label>
                    <x-input type="time" name="delivery_time" id="delivery_time" :value="isset($order->delivery_time)
                        ? Carbon::createFromFormat('H:i:s', $order->delivery_time)->format('H:i')
                        : null" required="true"
                        :placeholder="__('Choose delivery time')" />
                </div>
            @endif


            {{-- Categories Information --}}
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light text-dark gap-1">
                        <i class="ti ti-route"></i>
                        @lang('Thể loại mặt hàng')
                    </div>
                    <div class="card-body">
                        @foreach ($categories as $category)
                            <x-input-checkbox :label="$category->name" :value="$category->id" :checked="old(
                                'categories',
                                collect($shipment->categories)
                                    ->pluck('id')
                                    ->toArray(),
                            )"
                                class="form-check-input" name="categories[]" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Discount Information -->
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-pink text-white">
                        @lang('Mã giảm giá')
                    </div>
                    <div class="card-body">
                        @if ($order->discount)
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-brand-codesandbox"></i>
                                    <label class="col-sm-4 col-form-label">@lang('Code'):</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="form-control-plaintext"> <strong>{{ $order->discount->code }}
                                        </strong></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-discount"></i>
                                    <label class=" col-form-label">@lang('Giá trị giảm giá'):</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="form-control-plaintext">
                                        <strong>{{ format_price($order->discount->discount_value) }} </strong></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-user-cog"></i>
                                    <label class=" col-form-label">@lang('Mã giảm giá thuộc'):</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="form-control-plaintext"> <strong>{{ $order->discount->source->name }}
                                        </strong></span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">@lang('No Discount Applied')</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Shipping Weight Range Information --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-trolley"></i>
                <label class="control-label">@lang('Trọng lượng')</label>
                <x-select name="weight_range_id" :required="true">
                    <x-select-option value="" :title="__('choose')" :selected="empty($shipment->weight_range_id)" />
                    @foreach ($weightRanges as $item)
                        <x-select-option :value="$item->id" :title="__($item->min_weight . '-' . $item->max_weight . ' Kg')" :selected="$item->id == $shipment->weight_range_id" />
                    @endforeach
                </x-select>
            </div>

            <!--advance_payment_amount -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-zoom-cancel"></i>
                    <label class="control-label">@lang('advance_payment_amount')</label>
                    <x-input-price name="advance_payment_amount" id="advance_payment_amount" :value="$order->advance_payment_amount"
                        :required="true" :placeholder="__('advance_payment_amount')" />
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
                    <x-input-price name="high_point_area_fee" id="high_point_area_fee" :value="$order->high_point_area_fee"
                        :required="true" :placeholder="__('high_point_area_fee')" />
                </div>
            </div>
            <!-- holiday_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i>
                    <label class="control-label">@lang('Số tiền phí ngày lễ')</label>
                    <x-input-price name="holiday_fee" id="holiday_fee" :value="$order->holiday_fee" :required="true"
                        :placeholder="__('holiday_fee')" />
                </div>
            </div>
            <!-- night_time_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i>
                    <label class="control-label">@lang('Số tiền phí giờ đêm')</label>
                    <x-input-price name="night_time_fee" id="night_time_fee" :value="$order->night_time_fee" :required="true"
                        :placeholder="__('night_time_fee')" />
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

            <!-- Order_issue c-delivery -->
            @if (!empty($order_issue) && $order_issue->isNotEmpty())
                <div class="col-md-12 col-12 mb-3 ">
                    <div class="card shipment-card">
                        <div class="card-header shipment-card-header text-bg-dark">Lý do trả hàng</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                @foreach ($order_issue as $items)
                                    <div>{{ $items->description }}</div>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

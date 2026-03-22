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
                    <x-input disabled name="code" :value="$order->code" :required="true" :placeholder="__('code')"/>
                </div>
            </div>

            <!-- created_at -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <i class="ti ti-calendar-stats"></i>
                    <label class="control-label">@lang('created_at'):</label>
                    <x-input type="date"
                             disabled
                             name="created_at"
                             :value="isset($order->created_at) ? format_date($order->created_at, 'Y-m-d') : null"
                             required="true"/>
                </div>
            </div>


            {{-- user  --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-plus"></i>
                <label class="control-label">@lang('customer'):</label>
                <x-select class="select2-bs5-ajax"
                          name="user_id"
                          id="user_id"
                          :data-url="route('admin.search.select.user')">
                    <x-select-option :option="$order->user->id"
                                     :value="$order->user->id"
                                     :title="$order->user->fullname .' - '. $order->user->phone"/>
                </x-select>
            </div>

            {{-- driver --}}
            <div class="col-md-6 col-12 mb-3">
                <i class="ti ti-user-plus"></i>
                <label class="control-label">@lang('driver'):</label>
                <x-select class="select2-bs5-ajax"
                          name="driver_id"
                          id="driver_id"
                          :data-url="route('admin.search.select.driver')">
                    @if ($order->driver)
                        <x-select-option :option="$order->driver->id"
                                         :value="$order->driver->id"
                                         :title="$order->driver->user->fullname .' - '. $order->driver->user->phone"/>
                    @else
                        <x-select-option :value="null" :title="__('No driver assigned')"/>
                    @endif
                </x-select>
            </div>


            <!-- pickup_address -->
            <div class="col-12 mb-3">
                <div class="col-12 d-flex align-items-center gap-2 position-absolute top-3">
                    <i class="ti ti-map-pin"></i>
                    <label >@lang('address')</label>
                </div>
                <x-input-pick-address
                        name="address"
                        :label="false"
                        :value="$shipment->start_address"
                        :placeholder="trans('pickAddress')"
                        :required="true"/>
                <x-input type="hidden" name="lat" :value="$shipment->start_latitude"/>
                <x-input type="hidden" name="lng" :value="$shipment->start_longitude"/>
            </div>

            {{--  end-address--}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="col-12 d-flex align-items-center gap-2 position-absolute top-3">
                        <i class="ti ti-map-pin"></i>
                        <label >@lang('pickAddress')</label>
                    </div>
                    <x-input-pick-end-address
                        :label="false"
                        name="end_address"
                        :placeholder="trans('pickAddress')"
                        :value="$shipment->end_address"
                    />
                    <x-input type="hidden"  name="end_lat" :value="$shipment->end_latitude"/>
                    <x-input type="hidden" name="end_lng" :value="$shipment->end_longitude"/>
                </div>
            </div>
            <!-- show map -->
            <div id="resultMap" class="w-100 " style="height: 400px"></div>
            <!-- detail map-->
            <div id="directions-panel" class="mb-3"></div>

            <!-- payment_method -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-credit-card"></i>
                    <label class="control-label">@lang('payment_method')</label>
                    <x-select name="payment_method" :required="true">
                        @foreach ($payment_method as $key => $value)
                            <x-select-option :option="$order->payment_method->value"
                                             :value="$key"
                                             :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <!--platform_fee -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-free-rights"></i>
                    <label class="control-label">@lang('platform_fee')</label>
                    <x-input-price name="platform_fee"
                                   id="platform_fee"
                                   :value="$order->platform_fee"
                                   :required="true"
                                   :placeholder="__('platform_fee')"/>
                </div>
            </div>
            <!--sub_total -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-coins"></i>
                    <label class="control-label">@lang('sub_total')</label>
                    <x-input-price name="sub_total"
                                   id="sub_total"
                                   :value="$order->sub_total"
                                   :required="true"
                                   :placeholder="__('sub_total')"/>
                </div>
            </div>

            <!-- Discount Information -->
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-pink text-white">
                        @lang('Mã giảm giá')
                    </div>
                    <div class="card-body">
                        @if($order->discount)
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-brand-codesandbox"></i>
                                    <label class="col-sm-4 col-form-label">@lang('Code'):</label>
                                </div>

                                <div class="col-sm-8">
                                    <span class="form-control-plaintext"><strong>{{ $order->discount->code }}</strong></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-discount"></i>
                                <label class=" col-form-label">@lang('Giá trị giảm giá'):</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="form-control-plaintext"><strong>{{ format_price($order->discount->discount_value) }}</strong></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 d-flex align-items-center gap-1">
                                    <i class="ti ti-user-cog"></i>
                                    <label class=" col-form-label">@lang('Mã giảm giá thuộc'):</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="form-control-plaintext"><strong>{{ $order->discount->source->name }}</strong></span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">@lang('No Discount Applied')</p>
                        @endif
                    </div>
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
                    <x-input-price name="total"
                                   id="total"
                                   :value="$order->total"
                                   :required="true"
                                   :placeholder="__('total')"/>
                </div>
            </div>

            <!-- Order_issue c-cide-car -->
            @if (!empty($order_issue) && $order_issue->isNotEmpty())
                <div class="col-md-12 col-12 mb-3 ">
                    <div class="card shipment-card">
                        <div class="card-header shipment-card-header text-bg-dark">Lý do trả hàng</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                @foreach($order_issue as $items)
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

@php
    use App\Enums\shipment\DeliveryStatus;
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
                    <label class="control-label">@lang('code')</label>
                    <x-input disabled name="code" :value="$shipment->id" :required="true" :placeholder="__('code')"/>
                </div>
            </div>

            <!-- created_at -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('created_at'):</label>
                    <x-input type="date" disabled name="created_at"
                             :value="isset($shipment->created_at) ? format_date($shipment->created_at, 'Y-m-d') : null"
                             required="true"/>
                </div>
            </div>


            {{-- user  --}}
            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('customer'):</label>
                <x-select class="select2-bs5-ajax" name="user_id" id="user_id"
                          :data-url="route('admin.search.select.user')">
                    <x-select-option :option="$shipment->user->id" :value="$shipment->user->id"
                                     :title="$shipment->user->fullname . ' - ' . $shipment->user->phone"/>
                </x-select>
            </div>

            <!-- Recipient Name -->
            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('recipient_name')</label>
                <x-input type="text" name="recipient_name" id="recipient_name" :value="$shipment->recipient_name"
                         required="true"
                         :placeholder="__('Enter recipient name')"/>
            </div>

            <!-- Recipient Phone -->
            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('recipient_phone')</label>
                <x-input type="tel" name="recipient_phone" id="recipient_phone" :value="$shipment->recipient_phone"
                         required="true"
                         :placeholder="__('Enter recipient phone number')"/>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('collect_on_delivery_amount')</label>
                <x-input-price type="tel" name="collect_on_delivery_amount" id="collect_on_delivery_amount"
                               :value="$shipment->collect_on_delivery_amount" required="true"
                               :placeholder="__('Enter collect on delivery amount')"/>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('Trọng lượng')</label>
                <x-select name="weight_range_id" :required="true">
                    <x-select-option value="" :title="__('choose')" :selected="empty($shipment->weight_range_id)"/>
                    @foreach ($weightRanges as $item)
                        <x-select-option :value="$item->id"
                                         :title="__($item->min_weight . '-' . $item->max_weight . ' Kg')"
                                         :selected="$item->id == $shipment->weight_range_id"/>
                    @endforeach
                </x-select>
            </div>

            <!-- pickup_address -->
            <div class="col-12 mb-3">
                <x-input-pick-address :label="trans('Địa chỉ lấy hàng')"
                                      name="address"
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

            {{-- Categories Information --}}
            <div class="col-12 mb-3">
                <div class="card bshipment-0 shadow-sm">
                    <div class="card-header bg-light text-dark">
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
                                              class="form-check-input" name="categories[]"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

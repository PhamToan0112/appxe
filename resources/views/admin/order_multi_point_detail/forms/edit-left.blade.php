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
                    <label class="control-label">@lang('Mã đơn hàng')</label>
                    <x-input disabled name="code" :value="$orderMultiPointDetail->order->code" :required="true" :placeholder="__('code')" />
                </div>
            </div>

            <!-- Recipient Name -->
            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('recipient_name')</label>
                <x-input type="text" name="recipient_name" id="recipient_name" :value="$orderMultiPointDetail->recipient_name" required="true"
                    :placeholder="__('Enter recipient name')" />
            </div>

            <!-- Recipient Phone -->
            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('recipient_phone')</label>
                <x-input type="tel" name="recipient_phone" id="recipient_phone" :value="$orderMultiPointDetail->recipient_phone" required="true"
                    :placeholder="__('Enter recipient phone number')" />
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('collect_on_delivery_amount')</label>
                <x-input-price type="tel" name="collect_on_delivery_amount" id="collect_on_delivery_amount"
                    :value="$orderMultiPointDetail->collect_on_delivery_amount" required="true" :placeholder="__('Enter collect on delivery amount')" />
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label class="control-label">@lang('Trọng lượng')</label>
                <x-select name="weight_range_id" :required="true">
                    <x-select-option value="" :title="__('choose')" :selected="empty($orderMultiPointDetail->weight_range_id)" />
                    @foreach ($weightRanges as $item)
                        <x-select-option :value="$item->id" :title="__($item->min_weight . '-' . $item->max_weight . ' Kg')" :selected="$item->id == $orderMultiPointDetail->weight_range_id" />
                    @endforeach
                </x-select>
            </div>

            <!-- pickup_address -->
            <div class="col-12 mb-3">
                <x-input-pick-address :label="trans('Địa chỉ lấy hàng')" name="address" :value="$orderMultiPointDetail->start_address" :placeholder="trans('pickAddress')"
                    :required="true" />
                <x-input type="hidden" name="lat" :value="$orderMultiPointDetail->start_latitude" />
                <x-input type="hidden" name="lng" :value="$orderMultiPointDetail->start_longitude" />
            </div>

            {{--  end-address --}}
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-end-address :label="trans('shipping_address')" name="end_address" :placeholder="trans('pickAddress')"
                        :value="$orderMultiPointDetail->end_address" />
                    <x-input type="hidden" name="end_lat" :value="$orderMultiPointDetail->end_latitude" />
                    <x-input type="hidden" name="end_lng" :value="$orderMultiPointDetail->end_longitude" />
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
                                collect($orderMultiPointDetail->categories)
                                    ->pluck('id')
                                    ->toArray(),
                            )"
                                class="form-check-input" name="categories[]" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

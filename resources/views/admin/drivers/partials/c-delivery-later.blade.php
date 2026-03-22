@php use App\Enums\Service\ServiceStatus; @endphp

<div class="card mb-3">
    <div class="card-header">
        <h4>{{ __('C-Delivery Later') }}</h4>
    </div>
    <div class="card-body">
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <input type="hidden" name="service_delivery_later" value="{{ ServiceStatus::Off->value }}">
                <x-input-switch label="{{ __('enableAutoAccept') }}"
                                name="service_delivery_later"
                                :value="ServiceStatus::On->value"
                                :checked="$driver->service_delivery_later === ServiceStatus::On"/>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="row">
                @foreach ($weightRanges as $weightRange)
                    @php
                        $existingRate = $driver->rateWeights->where('shipping_weight_range_id', $weightRange->id)->first();
                        $existingPrice = $existingRate ? $existingRate->price : null;
                    @endphp
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="control-label">{{ __('Weight Range') }}: {{ $weightRange->min_weight }}kg - {{ $weightRange->max_weight }}kg</label>
                            <input type="hidden" name="weightRange[{{ $weightRange->id }}][id]" value="{{ $weightRange->id }}">
                            <x-input-price type="text"
                                           class="form-control"
                                           id="weightRange[{{ $weightRange->id }}][price]"
                                           name="weightRange[{{ $weightRange->id }}][price]"
                                           placeholder="{{ __('Enter price for this range') }}"
                                           value="{{ old('weightRange.' . $weightRange->id . '.price', $existingPrice) }}"
                                           required/>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- service_delivery_later_price --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá cho mỗi điểm giao') }}:</label>
                <x-input-price name="delivery_later_fee_per_stop"
                               id="delivery_later_fee_per_stop"
                               :value="$driver->delivery_later_fee_per_stop"
                               :required="true"
                               :placeholder="__('Giá cho mỗi điểm giao')"/>
            </div>
        </div>
    </div>
</div>

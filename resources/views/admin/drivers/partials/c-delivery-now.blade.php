@php use App\Enums\Service\ServiceStatus; @endphp

<div class="card mb-3">
    <div class="card-header">
        <h4>{{ __('C-Delivery Now') }}</h4>
    </div>
    <div class="card-body row">
        {{-- C-Delivery Now Activation --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <input type="hidden" name="service_delivery_now" value="{{ ServiceStatus::Off->value }}">
                <x-input-switch label="{{ __('enableAutoAccept') }}"
                                name="service_delivery_now"
                                :value="ServiceStatus::On->value"
                                :checked="$driver->service_delivery_now === ServiceStatus::On"/>
            </div>
        </div>

        {{-- C-Delivery Now Price --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá C-Delivery now') }}:</label>
                <x-input-price name="service_delivery_now_price"
                               id="service_delivery_now_price"
                               :value="$driver->service_delivery_now_price"
                               :required="true"
                               :placeholder="__('Giá C-Delivery now')"/>
            </div>
        </div>
    </div>
</div>

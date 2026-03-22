@php use App\Enums\Service\ServiceStatus; @endphp

<div class="card mb-3">
    <div class="card-header">
        <h4>{{ __('C-Ride') }}</h4>
    </div>
    <div class="card-body row">
        {{-- C-Ride Activation --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <input type="hidden" name="service_ride" value="{{ ServiceStatus::Off->value }}">
                <x-input-switch label="{{ __('enableAutoAccept') }}"
                                name="service_ride"
                                :value="ServiceStatus::On->value"
                                :checked="$driver->service_ride === ServiceStatus::On"/>
            </div>
        </div>

        {{-- C-Ride Price --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá C-Ride') }}:</label>
                <x-input-price name="service_ride_price"
                               id="service_ride_price"
                               :value="$driver->service_ride_price"
                               :required="true"
                               :placeholder="__('Giá C-Ride')"/>
            </div>
        </div>
    </div>
</div>

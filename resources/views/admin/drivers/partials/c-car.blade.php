@php use App\Enums\Service\ServiceStatus; @endphp

<div class="card mb-3">
    <div class="card-header">
        <h4>{{ __('C-Car') }}</h4>
    </div>
    <div class="card-body row">
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <input type="hidden" name="service_car" value="{{ ServiceStatus::Off->value }}">
                <x-input-switch label="{{ __('enableAutoAccept') }}"
                                name="service_car"
                                :value="ServiceStatus::On->value"
                                :checked="$driver->service_car === ServiceStatus::On"/>
            </div>
        </div>
        {{-- service_car_price --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá C-Car') }}:</label>
                <x-input-price name="service_car_price"
                               id="service_car_price"
                               :value="$driver->service_car_price"
                               :required="true"
                               :placeholder="__('Giá C-Car')"/>
            </div>
        </div>
    </div>
</div>

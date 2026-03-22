@php use App\Enums\Service\ServiceStatus; @endphp

<div class="card mb-3">
    <div class="card-header">
        <h4>{{ __('C-Intercity Settings') }}</h4>
    </div>
    <div class="card-body row">
        {{-- C-Intercity Activation --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <input type="hidden" name="service_intercity" value="{{ ServiceStatus::Off->value }}">
                <x-input-switch label="{{ __('enableAutoAccept') }}" name="service_intercity" :value="ServiceStatus::On->value"
                    :checked="$driver->service_intercity === ServiceStatus::On" />
            </div>
        </div>

        {{-- C-Intercity Price --}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('Giá C-Intercity') }}:</label>
                <x-input-price name="service_intercity_price" id="service_intercity_price" :value="$driver->service_intercity_price"
                    :required="true" :placeholder="__('Giá C-Intercity')" />
            </div>
        </div>

        <!-- service_intercity_start_time -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <i class="ti ti-clock-up"></i>
                <label class="control-label">@lang('service_intercity_start_time'):</label>
                <x-input type="time" name="service_intercity_start_time" :value="isset($driver->service_intercity_start_time)
                    ? $driver->service_intercity_start_time->format('H:i')
                    : null" required />
            </div>
        </div>

        <!-- service_intercity_end_time -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <i class="ti ti-clock-up"></i>
                <label class="control-label">@lang('service_intercity_end_time'):</label>
                <x-input type="time" name="service_intercity_end_time" :value="isset($driver->service_intercity_end_time)
                    ? $driver->service_intercity_end_time->format('H:i')
                    : null" required />
            </div>
        </div>


    </div>
</div>

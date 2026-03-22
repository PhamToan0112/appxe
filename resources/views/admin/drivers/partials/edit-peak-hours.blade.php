<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin vùng cao điểm') }}</h4>
    </div>
    <div class="row card-body">
{{--          peak_hour_price--}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('peak_hour_price') }}:</label>
                <x-input-price name="peak_hour_price"
                               id="peak_hour_price"
                               :value="$driver->peak_hour_price"
                               :required="true"
                               :placeholder="__('peak_hour_price')"/>
            </div>
        </div>

{{--          night_time_price--}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('night_time_price') }}:</label>
                <x-input-price name="night_time_price"
                               id="night_time_price"
                               :value="$driver->night_time_price"
                               :required="true"
                               :placeholder="__('night_time_price')"/>
            </div>
        </div>

{{--          holiday_price--}}
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">{{ __('holiday_price') }}:</label>
                <x-input-price name="holiday_price"
                               id="holiday_price"
                               :value="$driver->holiday_price"
                               :required="true"
                               :placeholder="__('holiday_price')"/>
            </div>
        </div>




    </div>
</div>


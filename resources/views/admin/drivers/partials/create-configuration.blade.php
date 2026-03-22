<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Cấu hình') }}</h4>
    </div>
    <div class="row card-body">
        {{--  current-address--}}
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-end-address :label="trans('pickup_address')"
                                          name="end_address"
                                          :placeholder="trans('pickup_address')"
                                          :required="true"/>
                <x-input type="hidden" name="end_lat"/>
                <x-input type="hidden" name="end_lng"/>
            </div>
        </div>

    </div>
</div>


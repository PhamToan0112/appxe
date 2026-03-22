<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h3>Tài xế: {{ $driver->user->fullname }}</h3>
            <x-input type="hidden" name="driver_id" :value="$driver->id" />
        </div>
        <div class="row card-body">
            {{--  start_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-map"></i>
                    <label class="control-label">@lang('start_address')</label>
                    <x-input name="start_address" :value="old('start_address')" :placeholder="__('start_address')" />
                </div>
            </div>
            {{--  end_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-map"></i>
                    <label class="control-label">@lang('end_address')</label>
                    <x-input name="end_address" :value="old('end_address')" :placeholder="__('end_address')" />
                </div>
            </div>

            {{-- price --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Giá vé của tuyến đường') }}:</label>
                    <x-input-price name="price" id="price" :value="old('price')" :required="true"
                        :placeholder="__('Giá vé của tuyến đường')" />
                </div>
            </div>

            {{-- return_price --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('return_price') }}:</label>
                    <x-input-price name="return_price" id="return_price" :value="old('return_price')" :required="true"
                        :placeholder="__('return_price')" />
                </div>
            </div>
        </div>


    </div>
</div>

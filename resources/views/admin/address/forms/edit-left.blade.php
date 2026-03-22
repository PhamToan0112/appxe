<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            @if (isset($driver_id))
                <h3>Tài xế:
                    <x-link :href="route('admin.driver.edit', $driver_id)">
                        <span>{{ $fullname }}</span>
                    </x-link>
                </h3>
            @else
                <h3>Khách hàng:
                    <x-link :href="route('admin.user.edit', $user_id)">
                        {{ $fullname }}
                    </x-link>
                </h3>
            @endif
        </div>
        <div class="row card-body">

            {{-- Địa chỉ gợi ý  --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-input name="name" :value="$name" :required="true" :placeholder="__('name')" />
                </div>
            </div>

            {{--  start_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')" name="address" :value="$address->address" :placeholder="trans('pickAddress')"
                        :required="true" />
                    <x-input type="hidden" name="lat" :value="$address->latitude" />
                    <x-input type="hidden" name="lng" :value="$address->longitude" />
                </div>
            </div>
        </div>
    </div>
</div>

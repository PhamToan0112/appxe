<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            @if (isset($driver->id))
                <h3>Tài xế:
                    <x-link :href="route('admin.driver.edit', $driver->id)">
                        <span>{{ $driver->user->fullname }}</span>
                    </x-link>
                </h3>
                <x-input type="hidden" name="user_id" :value="$driver->user_id" />
            @else
                <h3>Khách hàng:
                    <x-link :href="route('admin.user.edit', $user->id)">
                        <span>{{ $user->fullname }}</span>
                    </x-link>
                </h3>
                <x-input type="hidden" name="user_id" :value="$user->id" />
            @endif

        </div>
        <div class="row card-body">
            {{-- Địa chỉ gợi ý  --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-input name="name" :value="old('name')" :required="true" :placeholder="__('name')" />
                </div>
            </div>
            
            {{--  start_address --}}
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')"
                                          name="address"
                                          :value="old('address')"
                                          :placeholder="trans('pickAddress')"
                        :required="true" />
                    <x-input type="hidden" name="lat" :value="old('lat')" />
                    <x-input type="hidden" name="lng" :value="old('lng')" />
                </div>
            </div>

        </div>



    </div>
</div>

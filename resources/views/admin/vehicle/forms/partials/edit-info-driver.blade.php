<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Chủ xe') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Fullname -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="control-label">@lang('fullname'):</label>
                    <x-input name="fullname"
                             :value="$vehicle->vehicle_owner->fullname ?? null"
                             :required="true"
                             :placeholder="__('fullname')"/>
                </div>
            </div>
            <!-- email -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('email'):</label>
                    <x-input-email name="email" :value="$vehicle->vehicle_owner->email ?? null" :required="true"/>
                </div>
            </div>
            <!-- Phone -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="control-label">@lang('phone'):</label>
                    <x-input-phone name="phone"
                                   :value="$vehicle->vehicle_owner->phone ?? null"
                                   :required="true"/>
                </div>
            </div>
            <!-- Gender -->
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="control-label">@lang('gender'):</label>
                    <x-select name="gender" :required="true">
                        @foreach ($gender as $key => $value)
                            <x-select-option :value="$key" :title="__($value)"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- birthday -->
            <div class="col-md-3 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('birthday'):</label>
                    <x-input type="date" name="birthday"
                            :value="isset($vehicle->vehicle_owner->birthday ) ? format_date($vehicle->vehicle_owner->birthday, 'Y-m-d') : null"
                            required="true"/>
                </div>
            </div>
            <!-- ID Card -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="control-label">@lang('id_card'):</label>
                    <x-input name="id_card"
                             :value="old('id_card')"
                             :value="$vehicle->vehicle_owner->id_card ?? null"
                             :placeholder="__('id_card')"/>
                </div>
            </div>
            {{-- bank_name input --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_name'):</label>
                    <x-input name="bank_name" :value="$vehicle->vehicle_owner->bank_name ?? old('bank_name')"
                            :placeholder="__('bank_name')"/>
                </div>
            </div>
            {{-- bank_account_name input --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_account_name'):</label>
                    <x-input name="bank_account_name" :value="$vehicle->vehicle_owner->bank_account_name ?? old('bank_account_name')"
                            :placeholder="__('bank_account_name')"/>
                </div>
            </div>
            {{-- bank_account_number input --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_account_number'):</label>
                    <x-input name="bank_account_number"
                            :value="$vehicle->vehicle_owner->bank_account_number ?? old('bank_account_number')"
                            :placeholder="__('bank_account_number')"/>
                </div>
            </div>
            <!-- address -->
{{--            <div class="col-12">--}}
{{--                <div class="mb-3">--}}
{{--                    <x-input-pick-address :label="trans('address')"--}}
{{--                                          name="address"--}}
{{--                                          :value="$vehicle->vehicle_owner->address"--}}
{{--                                          :placeholder="trans('pickAddress')" :required="true"/>--}}
{{--                    <x-input type="hidden" name="lat" :value="$vehicle->vehicle_owner->latitude "/>--}}
{{--                    <x-input type="hidden" name="lng" :value="$vehicle->vehicle_owner->longitude "/>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- ID Card Front -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('id_card_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="id_card_front"
                                                :value="$vehicle->vehicle_owner->id_card_front ?? null"
                                                showImage="featureImageIdCardFront"/>
                    </div>
                </div>
            </div>
            <!-- ID Card Back -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('id_card_back')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="id_card_back"
                            :value="$vehicle->vehicle_owner->id_card_back ?? null"
                            showImage="featureImageIdCardBack"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


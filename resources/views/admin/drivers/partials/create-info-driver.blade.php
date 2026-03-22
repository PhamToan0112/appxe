<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Tài xế') }}</h4>
    </div>
    <div class="row card-body">
        <div class="mb-3">
            <label for=""><span class="ti ti-map"></span> {{ __('Khu vực') }}</label>
            <x-select name="area_id" id="area_id" class="select2-bs5-ajax"
                data-url="{{ route('admin.search.select.area') }}" :required="true">
            </x-select>
        </div>
        <!-- Fullname -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label"><span class="ti ti-user"></span> @lang('fullname'):</label>
                <x-input name="user_info[fullname]" :value="old('user_info[fullname]')" :required="true" :placeholder="__('fullname')" />
            </div>
        </div>
        <!-- email -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label"><span class="ti ti-mail"></span> @lang('email'):</label>
                <x-input-email name="user_info[email]" :value="old('user_info[email]')" />
            </div>
        </div>
        <!-- new password -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label"><span class="ti ti-lock"></span> @lang('password'):</label>
                <x-input-password name="password" :required="true" />
            </div>
        </div>
        <!-- new password confirmation-->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label"><span class="ti ti-lock"></span> @lang('passwordConfirm'):</label>
                <x-input-password name="password_confirmation" :required="true"
                    data-parsley-equalto="input[name='password']"
                    data-parsley-equalto-message="{{ __('passwordMismatch') }}" />
            </div>
        </div>
        <!-- phone -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label"><span class="ti ti-phone"></span> @lang('phone'):</label>
                <x-input-phone name="user_info[phone]" :value="old('user_info[phone]')" :required="true" />
            </div>
        </div>
        <!-- gender -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-gender-bigender"></span>
                    @lang('gender'):</label>
                <x-select name="user_info[gender]" :required="true">
                    @foreach ($gender as $key => $value)
                        <x-select-option :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
        </div>
        {{-- id_card input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-number"></span>
                    @lang('id_card'):</label>
                <x-input name="id_card" :value="old('id_card')" :required="true" :placeholder="__('id_card')" />
            </div>
        </div>

        <!-- birthday -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-cake"></span>
                    @lang('birthday'):</label>
                <x-input type="date" name="user_info[birthday]" :value="old('user_info[birthday]')" :required="true" />
            </div>
        </div>
        {{-- Bank Name --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-building-bank"></span>
                    @lang('bank_name'):</label>
                <x-select name="user_info[bank_id]" :required="true">
                    <x-select-option value="" :title="__('choose')" :selected="!old('bank_id')" />
                    @foreach ($banks as $bank)
                        <x-select-option :value="$bank->id" :title="__($bank->name)" :selected="$bank->id == old('bank_id')" />
                    @endforeach
                </x-select>
            </div>
        </div>


        {{-- bank_account_number --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-credit-card"></span>
                    @lang('bank_account_number'):</label>
                <x-input name="user_info[bank_account_number]" :value="old('user_info.bank_account_number', $driver->bank_account_number ?? '')" :placeholder="__('bank_account_number')" />
            </div>
        </div>

        {{-- address_name --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-map"></span>
                    @lang('Địa chỉ gợi ý'):</label>
                <x-input name="name" :value="old('Địa chỉ gợi ý')" :placeholder="__('Địa chỉ gợi ý')" />
            </div>
        </div>
        <!-- address -->
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-address :label="trans('Địa chỉ thường trú')" name="address" :placeholder="trans('pickup_address')" :required="true" />
                <x-input type="hidden" name="lat" />
                <x-input type="hidden" name="lng" />
            </div>
        </div>
        {{-- Emergency contact name input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user-circle"></span>
                    @lang('emergency_contact_name'):</label>
                <x-input name="emergency_contact_name" :value="old('emergency_contact_name')" :placeholder="__('emergency_contact_name')" />
            </div>
        </div>

        {{-- Emergency contact address input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-location"></span>
                    @lang('emergency_contact_address'):</label>
                <x-input name="emergency_contact_address" :value="old('emergency_contact_address')" :placeholder="__('emergency_contact_address')" />
            </div>
        </div>

        {{-- Emergency contact phone input --}}
        <div class="col-md-12 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-phone"></span>
                    @lang('emergency_contact_phone'):</label>
                <x-input name="emergency_contact_phone" :value="old('emergency_contact_phone')" :placeholder="__('emergency_contact_phone')" />
            </div>
        </div>
        {{-- id_card_front --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <span class="ti ti-id"></span>
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front" :value="old('id_card_front')"
                        showImage="featureImageIdCardFront" />
                </div>
            </div>
        </div>
        {{-- id_card_back --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <span class="ti ti-id"></span>
                    @lang('id_card_back')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_back" :value="old('id_card_back')"
                        showImage="featureImageIdCardBack" />
                </div>
            </div>
        </div>
        {{-- driver_license_front --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <span class="ti ti-id"></span>
                    @lang('driver_license_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="driver_license_front" :value="old('driver_license_front')"
                        showImage="featureImageDriverLicenseFront" />
                </div>
            </div>
        </div>
        {{-- driver_license_back --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <span class="ti ti-id"></span>
                    @lang('driver_license_back')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="driver_license_back" :value="old('driver_license_back')"
                        showImage="featureImageDriverLicenseBack" />
                </div>
            </div>
        </div>
    </div>
</div>

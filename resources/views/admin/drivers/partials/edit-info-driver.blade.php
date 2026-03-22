<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Tài xế') }}</h4>
    </div>
    <div class="row card-body">
        <!-- Fullname -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user"></span>
                    @lang('fullname'):</label>
                <x-input name="user_info[fullname]" :value="$driver->user->fullname" :required="true"
                    placeholder="{{ __('Họ và tên') }}" />
            </div>
        </div>

        <!-- email -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-mail"></span>
                    @lang('email'):</label>
                <x-input-email name="user_info[email]" :value="$driver->user->email" :required="true" />
            </div>
        </div>

        <!-- phone -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-phone"></span>
                    @lang('phone'):</label>
                <x-input-phone name="user_info[phone]" :value="$driver->user->phone" :required="true" />
            </div>
        </div>

        <!-- gender -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user-circle"></span>
                    @lang('gender'):</label>
                <x-select name="user_info[gender]" :required="true">
                    @foreach ($gender as $key => $value)
                        <x-select-option :option="$driver->user->gender->value" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
        </div>
        <!-- new password -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-lock"></span>
                    @lang('password'):</label>
                <x-input-password name="password" />
            </div>
        </div>
        <!-- new password confirmation-->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-lock"></span>
                    @lang('passwordConfirm'):</label>
                <x-input-password name="password_confirmation"
                    data-parsley-equalto="input[name='password']"
                    data-parsley-equalto-message="{{ __('passwordMismatch') }}" />
            </div>
        </div>
        <!-- birthday -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-calendar"></span>
                    @lang('birthday'):</label>
                <x-input type="date" name="user_info[birthday]" :value="isset($driver->user->birthday) ? format_date($driver->user->birthday, 'Y-m-d') : null" required="true" />
            </div>
        </div>

        {{-- id_card input --}}
        <div class="col-md-12 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-id"></span>
                    @lang('id_card'):</label>
                <x-input name="id_card" :value="$driver->id_card ?? old('id_card')" :required="true" :placeholder="__('id_card')" />
            </div>
        </div>
        <div class="col-md-6 col-12 mb-3">
            <label class="control-label">
                <span class="ti ti-building-bank"></span>
                @lang('bank')</label>
            <x-select name="user_info[bank_id]" :required="true">
                <x-select-option value="" :title="__('choose')" :selected="!optional($driver->user->bank)->id" />
                @foreach ($banks as $bank)
                    <x-select-option :value="$bank->id" :title="__($bank->name)" :selected="$bank->id == optional($driver->user->bank)->id" />
                @endforeach
            </x-select>
        </div>


        {{-- bank_account_number input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-credit-card"></span>
                    @lang('bank_account_number'):</label>
                <x-input name="user_info[bank_account_number]" :value="old('user_info.bank_account_number', $driver->user->bank_account_number ?? '')" :placeholder="__('bank_account_number')" />
            </div>
        </div>

        {{-- Emergency contact name input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user-check"></span>
                    @lang('emergency_contact_name'):</label>
                <x-input name="emergency_contact_name" :value="$driver->emergency_contact_name ?? old('emergency_contact_name')" :placeholder="__('emergency_contact_name')" />
            </div>
        </div>

        {{-- Emergency contact address input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-target"></span>
                    @lang('emergency_contact_address'):</label>
                <x-input name="emergency_contact_address" :value="$driver->emergency_contact_address ?? old('emergency_contact_address')" :placeholder="__('emergency_contact_address')" />
            </div>
        </div>

        {{-- Emergency contact phone input --}}
        <div class="col-md-12 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-phone"></span>
                    @lang('emergency_contact_phone'):</label>
                <x-input name="emergency_contact_phone" :value="$driver->emergency_contact_phone ?? old('emergency_contact_phone')" :placeholder="__('emergency_contact_phone')" />
            </div>
        </div>
        <!-- address -->
        <x-link :href="route('admin.address.create', $driver->user_id)">
            <span class="ms-1 my-2 float-end">
                <span class="ti ti-plus"></span>
                @lang('Thêm mới')</span>
        </x-link>
        <div class="col-md-12 col-12">
            @if ($driver->user->addresses->isNotEmpty())
                <div>
                    <ul class="list-group">
                        @foreach ($driver->user->addresses as $address)
                            <li class="list-group-item">
                                <x-link :href="route('admin.address.edit', ['id' => $address->id])">
                                    <span>Chi tiết</span>
                                </x-link>
                                <br>
                                <strong>{{ __('Địa chỉ:') }}</strong> {{ $address->address }}
                                <br>
                                <strong>{{ __('Loại địa chỉ:') }}</strong> {{ __($address->type->label()) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div>
                    <p>{{ __('Không có địa chỉ nào được liên kết với người dùng này.') }}</p>
                </div>
            @endif
        </div>


        {{-- id_card_front --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <span class="ti ti-id"></span>
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front" :value="$driver->id_card_front"
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
                    <x-input-image-ckfinder name="id_card_back" :value="$driver->id_card_back" showImage="featureImageIdCardBack" />
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
                    <x-input-image-ckfinder name="driver_license_front" :value="$driver->driver_license_front"
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
                    <x-input-image-ckfinder name="driver_license_back" :value="$driver->driver_license_back"
                        showImage="featureImageDriverLicenseBack" />
                </div>
            </div>
        </div>

    </div>
</div>

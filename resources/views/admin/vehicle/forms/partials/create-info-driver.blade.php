<div class="container">
    <div class="row">
        <div class="mb-3 mt-3">
            <label for="">{{ __('Khu vực') }}</label>
            <x-select name="area_id"
            id="area_id"
            class="select2-bs5-ajax"
            data-url="{{ route('admin.search.select.area') }}"
            :required="true">
           </x-select>
        </div>
        <!-- Fullname -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('fullname'):</label>
                <x-input name="fullname"
                         :value="old('fullname]')"
                         :required="true"
                         :placeholder="__('fullname')"/>
            </div>
        </div>
        <!-- email -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('email'):</label>
                <x-input-email name="email" :value="old('email]')"/>
            </div>
        </div>
        <!-- Phone -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('phone'):</label>
                <x-input-phone name="phone"
                               :value="old('phone]')"
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
                <x-input type="date" name="birthday" :value="old('birthday]')"
                         :required="true"/>
            </div>
        </div>
        <!-- ID Card -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('id_card'):</label>
                <x-input name="id_card" :value="old('id_card')" :required="true"
                         :placeholder="__('id_card')"/>
            </div>
        </div>
        {{-- bank_name --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('bank_name'):</label>
                <x-input name="bank_name" :value="old('bank_name')"
                         :placeholder="__('bank_name')"/>
            </div>
        </div>
        {{-- bank_account_name --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('bank_account_name'):</label>
                <x-input name="bank_account_name" :value="old('bank_account_name')"
                         :placeholder="__('bank_account_name')"/>
            </div>
        </div>
        {{-- bank_account_number --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('bank_account_number'):</label>
                <x-input name="bank_account_number" :value="old('bank_account_number')"
                         :placeholder="__('bank_account_number')"/>
            </div>
        </div>
        <!-- Address -->
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-address :label="trans('address')"
                                      name="address"
                                      :placeholder="trans('pickAddress')"
                                      :required="true"/>
                <x-input type="hidden" name="lat"/>
                <x-input type="hidden" name="lng"/>
            </div>
        </div>
        <!-- ID Card Front -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front"
                                            :value="old('id_card_front')"
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
                        :value="old('id_card_back')"
                        showImage="featureImageIdCardBack"/>
                </div>
            </div>
        </div>
    </div>
</div>

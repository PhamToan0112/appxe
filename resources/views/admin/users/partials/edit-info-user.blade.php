<div class="card">
    <div class="card-header justify-content-center">
        <h2 class="mb-0">{{ __('Thông tin Thành viên') }}</h2>

    </div>
    <div class="row card-body">
        <!-- Fullname -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user"></span>
                    {{ __('Họ và tên') }}:</label>
                <x-input name="fullname" :value="$user->fullname" :required="true" placeholder="{{ __('Họ và tên') }}" />
            </div>
        </div>
        <!-- email -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-mail"></span>
                    {{ __('Email') }}:</label>
                <x-input-email name="email" :value="$user->email" :required="true" />
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
                <x-input-password name="password_confirmation" data-parsley-equalto="input[name='password']"
                    data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
            </div>
        </div>
        <!-- phone -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-phone"></span>
                    {{ __('Số điện thoại') }}:</label>
                <x-input-phone name="phone" :value="$user->phone" :required="true" />
            </div>
        </div>
        <!-- birthday -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-calendar"></span>
                    @lang('birthday'):</label>
                <x-input type="date" name="birthday" :value="isset($user->birthday) ? format_date($user->birthday, 'Y-m-d') : null" required="true" />
            </div>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="control-label">
                <span class="ti ti-wallet"></span>
                @lang('bank')</label>
            <x-select name="bank_id" :required="true">
                <x-select-option value="" :title="__('choose')" :selected="!optional($user->bank)->id" />
                @foreach ($banks as $bank)
                    <x-select-option :value="$bank->id" :title="__($bank->name)" :selected="$bank->id == optional($user->bank)->id" />
                @endforeach
            </x-select>
        </div>

        {{-- bank_account_number input --}}
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-credit-card"></span>
                    @lang('bank_account_number'):</label>
                <x-input name="bank_account_number" :value="old('bank_account_number', $user->bank_account_number ?? '')" :placeholder="__('bank_account_number')" />
            </div>
        </div>

        <!-- gender -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label class="control-label">
                    <span class="ti ti-user-circle"></span>
                    {{ __('Giới tính') }}:</label>
                <x-select name="gender" :required="true">
                    <x-select-option value="" :title="__('Chọn Giới tính')" />
                    @foreach ($gender as $key => $value)
                        <x-select-option :option="$user->gender->value" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
        </div>
        <!-- address -->
        <x-link :href="route('admin.address.create', $user->id)">
            <span class="ms-1 my-2 float-end">@lang('Thêm mới')</span>
        </x-link>
        <div class="col-12 ">
            @if ($user->addresses->isNotEmpty())
                <div class="col-12">
                    <ul class="list-group">
                        @foreach ($user->addresses as $address)
                            <li class="list-group-item">
                                <x-link :href="route('admin.address.edit', ['id' => $address->id])">
                                    <span>Chi tiết</span>
                                </x-link>
                                <br>
                                <strong>{{ __('Địa chỉ:') }}</strong> {{ $address->address }}
                                <br>
                                <strong>{{ __('Loại địa chỉ:') }}</strong> {{ __($address->type->label()) }}
                                @if ($address->name)
                                    <br>
                                    <strong>{{ __('Địa chỉ gợi ý:') }}</strong> {{ $address->name }}
                                @endif
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


    </div>
</div>

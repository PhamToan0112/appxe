@php use App\Enums\Driver\AutoAccept; @endphp
<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            <span class="ti ti-alert-circle me-1"></span>
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="w-100 d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"
                    class="flex-column gap-1 text-wrap p-2 flex-grow-1" />
                <x-link :href="route('admin.driver.index')" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
        </div>


    </div>

    <!-- is_online -->
    <div class="my-3 card">
        <div class="card-header">
            <span class="ti ti-status-change me-1"></span>
            @lang('Trạng thái Online')
        </div>
        <div class="card-body p-2">
            <x-select name="user_info[active]" :required="true">
                @foreach ($active as $key => $value)
                    <x-select-option :option="$driver->user->active->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>
    <!-- order_accepted -->
    <div class="mb-3 card">
        <div class="card-header">
            <span class="ti ti-checkbox me-1"></span>
            @lang('Trạng thái nhận đơn')
        </div>
        <div class="card-body p-2">
            <x-select name="order_status" :required="true">
                @foreach ($order_status as $key => $value)
                    <x-select-option :option="$driver->order_status" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>


    <!-- status -->
    <div class="my-3 card">
        <div class="card-header">
            <span class="ti ti-status-change me-1"></span>
            @lang('Trạng thái tài khoản')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$driver->user->status->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>
    <!-- verified -->
    <div class="my-3 card">
        <div class="card-header">
            <span class="ti ti-circle-check me-1"></span>
            @lang('ADMIN xác nhận tài xế')
        </div>
        <div class="card-body p-2">
            <x-select name="is_verified" :required="true">
                @foreach ($verified as $key => $value)
                    <x-select-option :option="$driver->is_verified->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <span class="ti ti-photo me-1"></span>
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="user_info[avatar]" :value="$driver->user->avatar" showImage="featureImage" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span class="ti ti-settings-automation me-1"></span>
            @lang('autoAccept')
        </div>

        <div class="card-body p-2">
            <x-input-switch label="{{ __('enableAutoAccept') }}" name="auto_accept" :value="AutoAccept::Auto->value"
                :checked="$driver->auto_accept === AutoAccept::Auto" />

        </div>
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <span class="ti ti-alert-circle me-2"></span>
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
    <div class="card mb-3">
        <div class="card-header">
            <span class="ti ti-photo me-2"></span>
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="user_info[avatar]" showImage="avatar" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span class="ti ti-settings-automation me-2"></span>
            @lang('autoAccept')
        </div>
        <div class="card-body p-2">
            <x-input-switch label="{{ __('enableAutoAccept') }}" name="auto_accept" :value="\App\Enums\Driver\AutoAccept::Auto->value"
                :checked="old('auto_accept', 1)" />
        </div>
    </div>


</div>

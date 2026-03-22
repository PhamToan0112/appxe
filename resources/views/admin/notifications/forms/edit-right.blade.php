@php use App\Enums\Notification\MessageType; @endphp
<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings"></i>
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save" />
                <x-link :href="route('admin.notification.index')" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
            <x-button.modal-delete data-route="{{ route('admin.notification.delete', $notification->id) }}"
                :title="__('delete')" />
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-settings-cancel"></i>
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select class="select2-bs5-ajax" name="status" :value="old('status')" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$notification->status->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header gap-1">
            <i class="ti ti-brand-adobe"></i>
            @lang('Loại thông báo')
        </div>
        <div class="card-body p-2">
            <x-select class="select2-bs5-ajax" name="type" :value="old('Loại thông báo')" :required="true">
                @foreach ($message_type as $key => $value)
                    <x-select-option :option="$notification->type->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>

    @if ($notification->type !== MessageType::UNCLASSIFIED && $notification->type !== MessageType::PAYMENT)
        <div class="card mb-3">
            <div class="card-header gap-1">
                <i class="ti ti-user-check"></i>
                @lang('ADMIN Xác nhận')
            </div>
            <div class="card-body p-2">
                <x-select class="select2-bs5-ajax" name="is_verified" :value="old('is_verified')" :required="true">
                    @foreach ($is_verified as $key => $value)
                        <x-select-option :option="$notification->is_verified->value" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
        </div>
    @endif
    @if ($notification->type === MessageType::DEPOSIT)
        <div class="card mb-3">
            <div class="card-header gap-1">
                <i class="ti ti-photo-check"></i>
                @lang('Hình ảnh')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder name="confirmation_image" :value="$notification->confirmation_image" showImage="featureImage" />
            </div>
        </div>
    @endif

</div>

@php use App\Enums\Area\AreaStatus; @endphp
<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="w-100 d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"
                    class="flex-column gap-1 text-wrap p-2 flex-grow-1" />
                <x-link :href="route('admin.area.index')" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$area->status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('peak_status')
        </div>

        <div class="card-body p-2">
            <input type="hidden" name="peak_status" value="{{ AreaStatus::Off->value }}">
            <x-input-switch label="{{ __('Bật/Tắt') }}" name="peak_status" :value="AreaStatus::On->value" :checked="$area->peak_status === AreaStatus::On" />

        </div>
    </div>
</div>

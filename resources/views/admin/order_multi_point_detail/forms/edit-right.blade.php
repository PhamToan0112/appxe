@php use App\Enums\OpenStatus; @endphp
<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save" />
                <a class="btn btn-secondary" href="{{ route('admin.cMulti.edit', $orderMultiPointDetail->order_id) }}">
                    {{ __('Quay lại') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('collection_from_sender_status')
        </div>
        <div class="card-body p-2">
            <x-select name="collection_from_sender_status" :required="true">
                @foreach ($collection_from_sender_status as $key => $value)
                    <x-select-option :option="$orderMultiPointDetail->collection_from_sender_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-header">
            @lang('delivery_status')
        </div>
        <div class="card-body p-2">
            <x-select name="delivery_status" :required="true">
                @foreach ($delivery_status as $key => $value)
                    <x-select-option :option="$orderMultiPointDetail->delivery_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

</div>

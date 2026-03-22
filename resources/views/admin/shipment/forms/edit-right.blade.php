@php use App\Enums\OpenStatus; @endphp
<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="w-100 d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"
                    class="flex-column gap-1 text-wrap p-2 flex-grow-1" />
                <x-link :href="route('admin.cMulti.shipment')" class="btn btn-outline w-50">
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
            <x-select name="shipment_status" :required="true">
                @foreach ($shipment_status as $key => $value)
                    <x-select-option :option="$shipment->shipment_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    {{--    <div class="card mb-3"> --}}
    {{--        <div class="card-header"> --}}
    {{--            {{ __('Vận chuyển') }} --}}
    {{--        </div> --}}
    {{--        <div class="card-body p-2"> --}}
    {{--            <x-select name="shipping_progress_status" :required="true"> --}}
    {{--                @foreach ($shipping_progress_status as $key => $value) --}}
    {{--                    <x-select-option :option="$shipment->shipping_progress_status->value" :value="$key" :title="$value" /> --}}
    {{--                @endforeach --}}
    {{--            </x-select> --}}
    {{--        </div> --}}
    {{--    </div> --}}

    <div class="card mb-3">
        <div class="card-header">
            @lang('collection_from_sender_status')
        </div>
        <div class="card-body p-2">
            <x-select name="collection_from_sender_status" :required="true">
                @foreach ($collection_from_sender_status as $key => $value)
                    <x-select-option :option="$shipment->collection_from_sender_status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>

    {{--    <div class="card mb-3"> --}}
    {{--        <div class="card-header"> --}}
    {{--            {{ __('Hình ảnh giao hàng') }} --}}
    {{--        </div> --}}
    {{--        <div class="card-body p-2"> --}}
    {{--            <x-input-image-ckfinder name="delivery_success_image" showImage="delivery_success_image" class="img-fluid" --}}
    {{--                :value="$shipment->delivery_success_image" /> --}}
    {{--        </div> --}}
    {{--    </div> --}}

</div>

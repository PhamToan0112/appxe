@extends('admin.layouts.master')
@push('libs-css')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.VehicleLine.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$vehicleLines->id" />
                <div class="row justify-content-center">
                    @include('admin.vehicleLines.forms.edit-left')
                    @include('admin.vehicleLines.forms.edit-right')
                </div>
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
    <script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
    <!-- ckfinder js -->
    @include('ckfinder::setup')
@endpush


@push('custom-js')
@endpush

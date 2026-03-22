@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.driver.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.drivers.forms.create-left')
                    @include('admin.drivers.forms.create-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/'.trans()->getLocale().'.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    @include('ckfinder::setup')
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
@endpush

@push('custom-js')
    @include('admin.drivers.scripts.scripts')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.layouts.modal.modal-pick-end-address')

    @include('admin.scripts.google-map-input')
    @include('admin.scripts.google-map-end-address-input')

@endpush

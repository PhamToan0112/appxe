@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.category.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$category->id"/>
                <x-input type="hidden" name="editPage" value="true"/>
                <div class="row justify-content-center">
                    @include('admin.category.forms.edit-left')
                    @include('admin.category.forms.edit-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
@endpush

@push('custom-js')
    @include('admin.vehicle.scripts.scripts')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.layouts.modal.modal-pick-end-address')

    @include('admin.scripts.google-map-input')
    @include('admin.scripts.google-map-end-address-input')
    @include('admin.orders.scripts.distance-address')


@endpush

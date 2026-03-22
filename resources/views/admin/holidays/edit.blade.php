@extends('admin.layouts.master')
@push('libs-css')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.holiday.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$holiday->id" />
                <div class="row justify-content-center">
                    @include('admin.holidays.forms.edit-left')
                    @include('admin.holidays.forms.edit-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
@endpush

@push('custom-js')

    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.layouts.modal.modal-pick-end-address')

    @include('admin.scripts.google-map-input')
    @include('admin.scripts.google-map-end-address-input')
@endpush

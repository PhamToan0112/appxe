@extends('admin.layouts.master')

@push('libs-css')

@endpush
@push('custom-css')
    <style>
        .wrap-loop-input .add-image-ckfinder{
            max-width: 300px;
            display: block;
        }
    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.setting.update')" type="put" :validate="true">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9">
                        @include('admin.settings.forms.c_ride.setting_c_ride')
                    </div>
                    @include('admin.settings.forms.edit-right')
                </div>
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
@include('ckfinder::setup')
@endpush

@push('custom-js')
    @include('admin.settings.forms.c_ride.script')
@endpush

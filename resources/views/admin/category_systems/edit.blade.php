@extends('admin.layouts.master')
@push('libs-css')
@endpush
@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-form :action="route('admin.category_system.update')" type="put" :validate="true">
            <x-input type="hidden" name="id" :value="$category_system->id" />
            <div class="row justify-content-center">
                @include('admin.category_systems.forms.edit-left')
                @include('admin.category_systems.forms.edit-right')
            </div>
        </x-form>
    </div>
</div>
@endsection

@push('libs-js')
    <!-- ckfinder js -->
    @include('ckfinder::setup')
@endpush


@push('custom-js')
@endpush
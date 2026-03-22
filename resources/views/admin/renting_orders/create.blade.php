@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@push('custom-css')
    <style>
        .product-variations{
            list-style: none;
        }
        .product-variations li{
            padding: 5px;
            cursor: default;
        }
        .product-variations li:hover{
            background-color: gainsboro;
        }
        .remove-item-product:hover{
            background-color:#f3dbdb;
        }
    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form id="formOrder" :action="route('admin.renting-order.store')" type="post" :validate="true" autocomplete="off">
                <div class="row justify-content-center">
                    @include('admin.renting_orders.forms.create-left')
                    @include('admin.renting_orders.forms.create-right')
                </div>
            </x-form>
        </div>
    </div>
@endsection
@push('libs-js')
<script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
<script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
@endpush
@push('custom-js')

@include('admin.renting_orders.scripts.scripts')

@endpush



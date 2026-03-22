@extends('admin.layouts.master')

@push('libs-css')
@endpush

@section('content')
    @php
        $discount = \App\Models\Discount::find(request()->route('discountId'));
    @endphp
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">
                        Danh sách đối tượng áp dụng cho mã:
                        <x-link :href="route('admin.discount.edit', $discount->id)" class="text-decoration-underline" :title="$discount->code" />
                    </h2>
                </div>
                <div class="card-body">
                    <x-form id="formMultiple" :action="route('admin.discount.multiple')" type="post" :validate="true">
                        <div class="table-responsive position-relative">
                            <x-admin.partials.toggle-column-datatable />
                            @isset($actionMultiple)
                                <x-admin.partials.select-action-multiple :actionMultiple="$actionMultiple" />
                            @endisset
                            {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
    {{ $dataTable->scripts() }}

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush

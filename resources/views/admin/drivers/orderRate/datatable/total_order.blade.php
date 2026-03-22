@if ($total_order > 0)
    <x-link :href="route('admin.driver.orders', $id)">
        {{ $total_order }}
        Đơn Hàng
    </x-link>
@else
    {{ $total_order }}
@endif

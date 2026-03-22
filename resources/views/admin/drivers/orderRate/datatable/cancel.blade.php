@if ($cancel > 0)
    <x-link :href="route('admin.driver.orders', $id)">
        {{ $cancel }}
        Đơn Hủy
    </x-link>
@else
    {{ $cancel }}
@endif

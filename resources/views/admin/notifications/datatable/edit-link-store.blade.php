@php
    $test = App\Models\Store::find($store_id);
@endphp
@if ($test)
<x-link :href="route('admin.store.edit', $test->id)" :title="$test->store_name" class="text-decoration-none" />
@endif

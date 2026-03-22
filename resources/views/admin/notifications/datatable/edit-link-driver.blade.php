@php
    $test = App\Models\Driver::find($driver_id);
@endphp
@if ($test)
<x-link :href="route('admin.driver.edit', $test->id)" :title="$test->user->fullname" class="text-decoration-none" />
@endif

@if ($row)
    @php
        $driver = \App\Models\Driver::find($row);
    @endphp

    <x-link :href="route('admin.driver.edit', $row)" :title="$driver->user->fullname" />
@else
    <span class="text-muted">{{ __('N/A') }}</span>
@endif

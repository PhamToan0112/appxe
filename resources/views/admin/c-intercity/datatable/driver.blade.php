@if($driver_id)
    <x-link :href="route('admin.driver.edit', $driver_id)" :title="$driver['user']['fullname']"/>
@else
    N/A
@endif

@if ($type = 'C_RIDE')
    <x-link :href="route('admin.cRide.edit', $id)" :title="$code" />
@else
    <x-link :href="route('admin.cDelivery.edit', $id)" :title="$code" />
@endif

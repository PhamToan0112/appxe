<x-link :href="route('admin.driver.edit', ['id' => $vehicle->driver->id])">
    <span>{{$vehicle->driver ? $vehicle->driver->user->fullname : 'N/A'}}</span>
</x-link>
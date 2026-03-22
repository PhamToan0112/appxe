@if(isset($stores) && $stores->count() > 0)
    @foreach($stores as $store)
        <div class="d-flex flex-column">
            <x-link :href="route('admin.store.edit', $store->id)" :title="$store->store_name" />
        </div>
    @endforeach
@else
    <div>N/A</div>
@endif

@if(isset($products) && $products->count() > 0)
    @foreach($products as $product)
        <div class="d-flex flex-column">
            <x-link :href="route('admin.product.edit', $product->id)" :title="$product->name" />
        </div>
    @endforeach
@else
    <div>N/A</div>
@endif

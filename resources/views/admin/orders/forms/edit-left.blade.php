@if($order->order_type === App\Enums\Order\OrderType::Booking)
    @include('admin.orders.partials.order-booking')
@endif

@if($order->order_type === App\Enums\Order\OrderType::Renting)
    @include('admin.orders.partials.order-renting')
@endif

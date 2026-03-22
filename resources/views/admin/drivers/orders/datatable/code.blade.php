@switch($orderType)
    @case(\App\Enums\Order\OrderType::C_Intercity)
        <x-link :href="route('admin.cIntercity.edit', $orderId)" :title="$code" />
    @break

    @case(\App\Enums\Order\OrderType::C_Delivery)
        <x-link :href="route('admin.cDelivery.edit', $orderId)" :title="$code" />
    @break

    @case(\App\Enums\Order\OrderType::C_RIDE)
        <x-link :href="route('admin.cRide.edit', $orderId)" :title="$code" />
    @break

    @case(\App\Enums\Order\OrderType::C_CAR)
        <x-link :href="route('admin.cRide.edit', $orderId)" :title="$code" />
    @break

    @case(\App\Enums\Order\OrderType::C_Multi)
        <x-link :href="route('admin.cMulti.edit', $orderId)" :title="$code" />
    @break

    @default
        N/A
    @break
@endswitch

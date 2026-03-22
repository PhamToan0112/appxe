<span @class([
    'badge',
    App\Enums\Order\OrderCDeliveryStatus::from($status)->badge(),
])>{{ \App\Enums\Order\OrderCDeliveryStatus::getDescription($status) }}</span>

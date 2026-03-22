<span @class([
    'badge',
    App\Enums\Order\OrderCRideCarStatus::from($status)->badge(),
])>{{ \App\Enums\Order\OrderCRideCarStatus::getDescription($status) }}</span>

<span @class([
    'badge',
    App\Enums\Order\OrderStatus::from($status ?? null)->badge(),
])>{{ \App\Enums\Order\OrderStatus::getDescription($status ?? null) }}</span>

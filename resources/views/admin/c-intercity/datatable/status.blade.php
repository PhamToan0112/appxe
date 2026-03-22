<span @class([
    'badge',
    App\Enums\Order\OrderCIntercityStatus::from($status)->badge(),
])>{{ \App\Enums\Order\OrderCIntercityStatus::getDescription($status) }}</span>

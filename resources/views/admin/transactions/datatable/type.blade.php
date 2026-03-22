<span @class([
    'badge',
    App\Enums\Transaction\TransactionType::from($type)->badge(),
])>{{ \App\Enums\Transaction\TransactionType::getDescription($type) }}</span>

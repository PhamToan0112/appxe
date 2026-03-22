<span @class([
    'badge',
    App\Enums\OpenStatus::from($collection_from_sender_status)->badge(),
])>{{ \App\Enums\OpenStatus::getDescription($collection_from_sender_status) }}</span>

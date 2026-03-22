<span @class([
    'badge',
    App\Enums\Area\AreaStatus::from($status)->badge(),
])>{{ \App\Enums\Area\AreaStatus::getDescription($status) }}</span>

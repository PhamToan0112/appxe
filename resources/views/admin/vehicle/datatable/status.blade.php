<span @class([
    'badge',
    App\Enums\Vehicle\VehicleStatus::from($status)->badge(),
])>{{ \App\Enums\Vehicle\VehicleStatus::getDescription($status) }}</span>

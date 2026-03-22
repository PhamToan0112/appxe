<span @class([
    'badge',
    App\Enums\Vehicle\VehicleType::from($type)->badge(),
])>{{ \App\Enums\Vehicle\VehicleType::getDescription($type) }}</span>

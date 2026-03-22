@if($trip_type !== null)
    <span @class([
        'badge',
        \App\Enums\Order\TripType::from($trip_type)->badge(),
    ])>{{ \App\Enums\Order\TripType::getDescription($trip_type) }}</span>
@else
    N/A
@endif

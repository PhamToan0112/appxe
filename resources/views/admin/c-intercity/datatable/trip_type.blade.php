<span @class([
    'badge',
    in_array($trip_type, App\Enums\Order\TripType::getValues())
        ? App\Enums\Order\TripType::from($trip_type)->badge()
        : '',
])>
    {{ in_array($trip_type, App\Enums\Order\TripType::getValues())
        ? \App\Enums\Order\TripType::getDescription($trip_type)
        : 'N/A' }}
</span>

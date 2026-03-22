<span @class([
    'badge',
    \App\Enums\Driver\DriverOrderStatus::from($status)->badge(),

])>
      {{ \App\Enums\Driver\DriverOrderStatus::getDescription($status) }}
</span>

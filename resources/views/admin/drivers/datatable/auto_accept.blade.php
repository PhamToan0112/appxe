<span @class([
    'badge',
    \App\Enums\Driver\AutoAccept::from($status)->badge(),

])>
      {{ \App\Enums\Driver\AutoAccept::getDescription($status) }}
</span>

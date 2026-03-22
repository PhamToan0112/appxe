<span @class([
    'badge',
    \App\Enums\OpenStatus::from( $active)->badge(),

])>
      {{ \App\Enums\OpenStatus::getDescription( $active) }}
</span>

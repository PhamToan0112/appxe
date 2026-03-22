<span @class([
    'badge',
    \App\Enums\Driver\VerificationStatus::from($is_verified)->badge(),

])>
      {{ \App\Enums\Driver\VerificationStatus::getDescription($is_verified) }}
</span>

<span @class([
    'badge',
    \App\Enums\Review\ReviewStatus::from($status)->badge(),
])>
    {{ \App\Enums\Review\ReviewStatus::getDescription($status) }}
</span>

<span @class([
    'badge',
    \App\Enums\Discount\DiscountStatus::from($status)->badge(),
])>
    {{ \App\Enums\Discount\DiscountStatus::getDescription($status) }}
</span>

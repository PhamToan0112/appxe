@php use App\Enums\Order\OrderCMultiStatus; @endphp
<span @class([
    'badge',
    App\Enums\Order\OrderCMultiStatus::from($status)->badge(),
])>{{ OrderCMultiStatus::getDescription($status) }}</span>

<span
    @class([
        'badge',
        App\Enums\Order\ShippingProgressStatus::from(
            $shipping_progress_status)->badge(),
    ])>{{ \App\Enums\Order\ShippingProgressStatus::getDescription($shipping_progress_status) }}</span>

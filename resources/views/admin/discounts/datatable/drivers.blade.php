@switch($driver_option)
    @case(\App\Enums\Discount\DiscountOption::None)
        Không áp dụng
    @break

    @case(\App\Enums\Discount\DiscountOption::All)
        Áp dụng cho tất cả
    @break

    @case(\App\Enums\Discount\DiscountOption::One)
        <x-link :href="route('admin.discount.apply', $discount->id)" :title="'Xem danh sách'" />
    @break

    @default
@endswitch

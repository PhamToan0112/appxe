<div class="card">
    <div class="card-header">
        <h4>{{ __('Đánh giá tài xế') }}</h4>
    </div>
    <div class="row card-body">
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    @if ($reviews != 0)
                        <div>
                            <span class="fw-bold">
                                {{ __('Trung bình: ') }}
                                {{ $reviews['avg'] }}
                                <i class="ti ti-star text-yellow"></i>
                            </span>

                            <x-link :href="route('admin.driver.reviews', $reviews['driver'])" class="">
                                <span class="ms-1 float-end">{{ __('(Xem đánh giá)') }}</span>
                            </x-link>
                        </div>
                        {!! statusBadge(App\Enums\Driver\DriverReviews::fromRating($reviews['avg'])) !!}
                    @else
                        <span class="fw-bold">{{ __('Tài xế chưa có đánh giá') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

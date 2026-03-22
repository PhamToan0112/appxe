<div class="card">
    <div class="card-header">
        <h4>{{ __('Danh sách đánh giá') }}
            {{ $reviews != 0 ? $reviews['total'] : 0 }}
        </h4>
    </div>

    <div class="row card-body">
        @if ($reviews != 0)
            @foreach ($reviews['reviews'] as $review)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="fw-bold">
                                    {{ $review->user->fullname }}:
                                    {{ $review->rating }}
                                    <i class="ti ti-star text-yellow"></i>
                                </span>
                                <br />

                                <x-link :href="route('admin.dashboard')">
                                    <span class="">
                                        ({{ $review->created_at->diffForHumans() }})
                                    </span>
                                </x-link>
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bold">
                                    {!! $review->content !!}
                                </span>
                            </div>

                            <div class="col-md-2">
                                {!! statusBadge(App\Enums\Review\ReviewStatus::from($review->status->value)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

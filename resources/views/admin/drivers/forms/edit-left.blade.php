<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Tài xế') }}</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="driver-info-tab" data-bs-toggle="tab"
                        data-bs-target="#driverInfo" type="button" role="tab" aria-controls="driverInfo"
                        aria-selected="true">
                        <i class="ti ti-user-check"></i>
                        {{ __('Thông tin cơ bản') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="registration-info-tab" data-bs-toggle="tab"
                        data-bs-target="#registrationInfo" type="button" role="tab"
                        aria-controls="registrationInfo" aria-selected="false">
                        <i class="ti ti-id"></i>
                        {{ __('Thông tin Đăng ký xe') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="wallet-info-tab" data-bs-toggle="tab" data-bs-target="#walletInfo"
                        type="button" role="tab" aria-controls="walletInfo" aria-selected="false">
                        <i class="ti ti-wallet"></i>
                        {{ __('Thông Tin Ví') }}
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="configuration-tab" data-bs-toggle="tab" data-bs-target="#configuration"
                        type="button" role="tab" aria-controls="configuration" aria-selected="false">
                        <i class="ti ti-settings"></i>
                        {{ __('Cấu hình') }}
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="peak-hours-tab" data-bs-toggle="tab" data-bs-target="#peakHours"
                        type="button" role="tab" aria-controls="peakHours" aria-selected="false">
                        <i class="ti ti-timeline-event-plus"></i>
                        {{ __('Giờ cao điểm') }}
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                        type="button" role="tab" aria-controls="reviews" aria-selected="false">
                        <i class="ti ti-star"></i>
                        {{ __('Đánh giá') }}
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="driverInfo" role="tabpanel"
                    aria-labelledby="driver-info-tab">
                    @include('admin.drivers.partials.edit-info-driver')
                </div>
                <div class="tab-pane fade" id="registrationInfo" role="tabpanel"
                    aria-labelledby="registration-info-tab">
                    <div id="vehicleFormsContainer">
                        @include('admin.drivers.partials.edit-registration')
                    </div>
                </div>
                <div class="tab-pane fade" id="walletInfo" role="tabpanel" aria-labelledby="wallet-info-tab">
                    @include('admin.users.partials.edit-wallet-info')
                </div>
                <div class="tab-pane fade" id="configuration" role="tabpanel" aria-labelledby="configuration-tab">
                    @include('admin.drivers.partials.edit-configuration')
                </div>
                <div class="tab-pane fade" id="peakHours" role="tabpanel" aria-labelledby="peak-hours-tab">
                    @include('admin.drivers.partials.edit-peak-hours')
                </div>

                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    @include('admin.drivers.partials.edit-reviews')
                </div>
            </div>
        </div>
    </div>
</div>

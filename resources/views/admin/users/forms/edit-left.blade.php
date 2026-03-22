<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin thành viên') }}</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active"
                            id="basic-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#basicInfo"
                            type="button"
                            role="tab"
                            aria-controls="basicInfo"
                            aria-selected="true">
                        <i class="ti ti-user-check"></i>
                        {{ __('Thông Tin Cơ Bản') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="additional-settings-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#additionalSettings"
                            type="button" role="tab"
                            aria-controls="additionalSettings"
                            aria-selected="false">
                        <i class="ti ti-settings"></i>
                        {{ __('Cấu Hình Bổ Sung') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="wallet-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#walletInfo"
                            type="button"
                            role="tab"
                            aria-controls="walletInfo"
                            aria-selected="false">
                        <i class="ti ti-wallet"></i>
                        {{ __('Thông Tin Ví') }}
                    </button>
                </li>

            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active"
                     id="basicInfo"
                     role="tabpanel"
                     aria-labelledby="basic-info-tab">
                    @include('admin.users.partials.edit-info-user')
                </div>
                <div class="tab-pane fade"
                     id="additionalSettings"
                     role="tabpanel"
                     aria-labelledby="additional-settings-tab">
                    @include('admin.users.partials.edit-configuration')
                </div>
                <div class="tab-pane fade"
                     id="walletInfo"
                     role="tabpanel"
                     aria-labelledby="wallet-info-tab">
                    @include('admin.users.partials.edit-wallet-info')
                </div>
            </div>
        </div>
    </div>
</div>

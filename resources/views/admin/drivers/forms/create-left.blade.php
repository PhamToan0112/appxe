<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Tài xế và Thông tin Đăng ký') }}</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active"
                            id="driver-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#driverInfo"
                            type="button"
                            role="tab"
                            aria-controls="driverInfo"
                            aria-selected="true">
                        <i class="ti ti-user-check"></i>
                        {{ __('Thông tin cơ bản') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="registration-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#registrationInfo"
                            type="button" role="tab"
                            aria-controls="registrationInfo"
                            aria-selected="false">
                        <i class="ti ti-id"></i>
                        {{ __('Thông tin Đăng ký xe') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="configuration-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#configuration"
                            type="button"
                            role="tab"
                            aria-controls="configuration"
                            aria-selected="false">
                        <i class="ti ti-settings"></i>
                        {{ __('Cấu hình') }}
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade show active mt-3"
                     id="driverInfo"
                     role="tabpanel"
                     aria-labelledby="driver-info-tab">
                    @include('admin.drivers.partials.create-info-driver')
                </div>
                <div class="tab-pane fade mt-3"
                     id="registrationInfo"
                     role="tabpanel"
                     aria-labelledby="registration-info-tab">
                    @include('admin.drivers.partials.create-registration')
                </div>
                <div class="tab-pane fade mt-3"
                     id="configuration"
                     role="tabpanel"
                     aria-labelledby="configuration-tab">
                    @include('admin.drivers.partials.create-configuration')
                </div>
            </div>
        </div>
    </div>
</div>


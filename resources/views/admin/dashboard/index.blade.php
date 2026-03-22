@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ __('Dashboard') }}</h2>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row row-cards">
                                    <!-- Area Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-map"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.area.index')" title="Khu vực"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountArea }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transaction Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-credit-card"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.transaction.index')" title="Giao dịch"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountTransaction }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notification Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-bell"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.notification.index')" title="Thông báo"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountNotification }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-article"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.post.index')" title="Bài viết"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountPost }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Holiday Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-polaroid"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.holiday.index')" title="Ngày lễ"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountHoliday }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Discount Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-ticket"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.discount.index')" title="Mã giảm giá"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountDiscount }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Category system Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-adjustments-horizontal"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.category_system.index')" title="Dịch vụ hệ thống"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountCategorySystem }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C-Ride/Car Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-motorbike"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.cRide.index')" title="C-Ride/Car"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountOrderCRideCar }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C-Delivery Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-package-export"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.cDelivery.index')" title="C-Delivery"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountOrderCDelivery }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C-Intercity Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-bus-stop"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.cIntercity.index')" title="C-Intercity"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountOrderCIntercity }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C-Multi Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-route"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.cIntercity.index')" title="C-Multi"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountOrderCMulti }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Report Order Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-report"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.report_order.index')" title="Báo cáo đơn hàng"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountReportOrder }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vehilce Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-car"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.vehicle.index')" title="Phương tiện"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountVehicle }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vehilce line Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-manual-gearbox"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.VehicleLine.index')" title="Dòng xe"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountVehicleLine }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- User Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-user"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.user.index')" title="Khách hàng"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountUser }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-user-pin"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.driver.index')" title="Tài xế"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountDriver }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slider Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-photo"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.slider.index')" title="Slider"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountSlider }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Role Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-user-check"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.role.index')" title="Vai trò"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountRole }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Admin Card -->
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="iconModuleMevivu ti ti-user-shield"></span>
                                                    </div>
                                                    <div class="col">
                                                        <x-link :href="route('admin.admin.index')" title="Quản trị viên"
                                                            class="font-weight-medium">
                                                        </x-link>
                                                        <div class="text-secondary">
                                                            Số lượng: {{ $rowCountAdmin }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

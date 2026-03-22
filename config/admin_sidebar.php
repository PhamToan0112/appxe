<?php

return [
    [
        'title' => 'Dashboard',
        'routeName' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => []
    ],
    [
        'title' => 'area',
        'routeName' => null,
        'icon' => '<i class="ti ti-map-pin"></i>',
        'roles' => [],
        'permissions' => ['createArea', 'viewArea', 'updateArea', 'deleteArea'],
        'sub' => [
            [
                'title' => 'Thêm khu vực',
                'routeName' => 'admin.area.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createArea'],
            ],
            [
                'title' => 'DS khu vực',
                'routeName' => 'admin.area.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewArea'],
            ]
        ]
    ],
    [
        'title' => 'transactions',
        'routeName' => null,
        'icon' => '<i class="ti ti-credit-card"></i>',
        'roles' => [],
        'permissions' => ['viewTransaction', 'deleteTransaction'],
        'sub' => [
            [
                'title' => 'DS giao dịch',
                'routeName' => 'admin.transaction.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewTransaction'],
            ]
        ]
    ],
    [
        'title' => 'notification',
        'routeName' => null,
        'icon' => '<i class="ti ti-bell-check"></i>',
        'roles' => [],
        'permissions' => ['createNotification', 'viewNotification', 'updateNotification', 'deleteNotification'],
        'sub' => [
            [
                'title' => 'Thêm thông báo',
                'routeName' => 'admin.notification.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createNotification'],
            ],
            [
                'title' => 'DS thông báo',
                'routeName' => 'admin.notification.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ],
            [
                'title' => 'DS thông báo nạp tiền',
                'routeName' => 'admin.notification.deposit',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ],
            [
                'title' => 'DS thông báo rút tiền',
                'routeName' => 'admin.notification.withdraw',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ],
            [
                'title' => 'DS thông báo thanh toán',
                'routeName' => 'admin.notification.payment',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ],
            [
                'title' => 'DS báo cáo',
                'routeName' => 'admin.notification.report',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ]
        ]
    ],
    [
        'title' => 'Bài viết',
        'routeName' => null,
        'icon' => '<i class="ti ti-article"></i>',
        'roles' => [],
        'permissions' =>
            [
                'createPost',
                'viewPost',
                'updatePost',
                'deletePost',
                'viewPostCategory',
                'createPostCategory',
                'updatePostCategory'
            ],
        'sub' => [
            [
                'title' => 'Thêm bài viết',
                'routeName' => 'admin.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createPost'],
            ],
            [
                'title' => 'DS bài viết',
                'routeName' => 'admin.post.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPost'],
            ],
            [
                'title' => 'DS chuyên mục',
                'routeName' => 'admin.post_category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPostCategory'],
            ]
        ]
    ],
    [
        'title' => 'Ngày Lễ',
        'routeName' => null,
        'icon' => '<i class="ti ti-slideshow"></i>',
        'roles' => [],
        'permissions' => ['createHoliday', 'viewHoliday', 'updateHoliday', 'deleteHoliday'],
        'sub' => [
            [
                'title' => 'Thêm Ngày Lễ',
                'routeName' => 'admin.holiday.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createHoliday'],
            ],
            [
                'title' => 'DS Ngày Lễ',
                'routeName' => 'admin.holiday.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewHoliday'],
            ],
        ]
    ],
    [
        'title' => 'Mã giảm giá',
        'routeName' => null,
        'icon' => '<i class="ti ti-ticket"></i>',
        'roles' => [],
        'permissions' => ['createDiscountCode', 'viewDiscountCode', 'updateDiscountCode', 'deleteDiscountCode'],
        'sub' => [
            [
                'title' => 'Thêm mã giảm giá',
                'routeName' => 'admin.discount.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createDiscountCode'],
            ],
            [
                'title' => 'Mã giảm giá còn hạn',
                'routeName' => 'admin.discount.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewDiscountCode'],
            ],
            [
                'title' => 'Mã giảm giá hết hạn',
                'routeName' => 'admin.discount.expired',
                'icon' => '<i class="ti ti-clock-cancel"></i>',
                'roles' => [],
                'permissions' => ['viewDiscountCode'],
            ],
        ]
    ],

    [
        'title' => 'Dịch Vụ Hệ thống',
        'routeName' => null,
        'icon' => '<i class="ti ti-bed"></i>',
        'roles' => [],
        'permissions' => ['viewServices', 'createServices', 'updateServices', 'deleteServices'],
        'sub' => [
            [
                'title' => 'Thêm Dịch Vụ',
                'routeName' => 'admin.category_system.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createServices'],
            ],
            [
                'title' => 'Danh sách Dịch Vụ',
                'routeName' => 'admin.category_system.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewServices'],
            ]
        ]
    ],
    [
        'title' => 'C-Ride/Car',
        'routeName' => null,
        'icon' => '<i class="ti ti-motorbike"></i>',
        'roles' => [],
        'permissions' => ['createCRideCar', 'viewCRideCar', 'updateCRideCar', 'deleteCRideCar'],
        'sub' => [
            [
                'title' => 'DS đơn hàng ',
                'routeName' => 'admin.cRide.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCRideCar'],
            ]
        ]
    ],
    [
        'title' => 'C-Delivery',
        'routeName' => null,
        'icon' => '<i class="ti ti-car"></i>',
        'roles' => [],
        'permissions' => [
            'createCDelivery',
            'viewCDelivery',
            'updateCDelivery',
            'deleteCDelivery',
            'viewWeightRange',
            'viewCategory',
            'createCategory',
            'updateCategory'
        ],
        'sub' => [
            [
                'title' => 'DS trọng lượng',
                'routeName' => 'admin.weightRange.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewWeightRange'],
            ],
            [
                'title' => 'Danh sách thể loại',
                'routeName' => 'admin.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCategory'],
            ],
            [
                'title' => 'DS đơn hàng ',
                'routeName' => 'admin.cDelivery.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCDelivery'],
            ]
        ]
    ],
    [
        'title' => 'C-Intercity',
        'routeName' => null,
        'icon' => '<i class="ti ti-motorbike"></i>',
        'roles' => [],
        'permissions' => ['createCIntercity', 'viewCIntercity', 'updateCIntercity', 'deleteCIntercity'],
        'sub' => [
            [
                'title' => 'DS đơn hàng ',
                'routeName' => 'admin.cIntercity.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCIntercity'],
            ],
            [
                'title' => 'DS chuyến đi ',
                'routeName' => 'admin.cIntercity.routes',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCIntercity'],
            ]
        ]
    ],
    [
        'title' => 'Đơn hàng đa điểm',
        'routeName' => null,
        'icon' => '<i class="ti ti-route"></i>',
        'roles' => [],
        'permissions' => ['createCMulti', 'updateCMulti', 'deleteCMulti', 'viewCMulti'],
        'sub' => [
            [
                'title' => 'DS đơn hàng ',
                'routeName' => 'admin.cMulti.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCMulti'],
            ],
            [
                'title' => 'DS Thông tin đa điểm',
                'routeName' => 'admin.cMulti.shipment',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewCMulti'],
            ]
        ]
    ],
    [
        'title' => 'Đơn hàng Report',
        'routeName' => null,
        'icon' => '<i class="ti ti-report"></i>',
        'roles' => [],
        'permissions' => ['viewReportOrder', 'deleteReportOrder'],
        'sub' => [
            [
                'title' => 'DS Báo cáo ',
                'routeName' => 'admin.report_order.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewReportOrder'],
            ],

        ]
    ],
    [
        'title' => 'Phương tiện',
        'routeName' => null,
        'icon' => '<i class="ti ti-motorbike"></i>',
        'roles' => [],
        'permissions' => ['viewVehicle', 'updateVehicle', 'createVehicle', 'deleteVehicle'],
        'sub' => [
            [
                'title' => 'Thêm phương tiện',
                'routeName' => 'admin.vehicle.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createVehicle'],
            ],
            [
                'title' => 'DS phương tiện ',
                'routeName' => 'admin.vehicle.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['createVehicle'],
            ],

        ]
    ],
    [
        'title' => 'Dòng xe',
        'routeName' => null,
        'icon' => '<i class="ti ti-manual-gearbox"></i>',
        'roles' => [],
        'permissions' => ['viewVehicleLines', 'updateVehicleLines', 'createVehicleLines', 'deleteVehicleLines'],
        'sub' => [
            [
                'title' => 'Thêm Dòng xe',
                'routeName' => 'admin.VehicleLine.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createVehicleLines'],
            ],
            [
                'title' => 'DS Dòng xe ',
                'routeName' => 'admin.VehicleLine.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['createVehicleLines'],
            ],

        ]
    ],
    [
        'title' => 'customer',
        'routeName' => null,
        'icon' => '<i class="ti ti-users"></i>',
        'roles' => [],
        'permissions' => ['createUser', 'viewUser', 'updateUser', 'deleteUser', 'createAddress'],
        'sub' => [
            [
                'title' => 'add',
                'routeName' => 'admin.user.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createUser'],
            ],
            [
                'title' => 'list',
                'routeName' => 'admin.user.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewUser'],
            ]
        ]
    ],

    [
        'title' => 'Tài Xế',
        'routeName' => null,
        'icon' => '<i class="ti ti-user"></i>',
        'roles' => [],
        'permissions' => ['createDriver', 'viewDriver', 'updateDriver', 'deleteDriver'],
        'sub' => [
            [
                'title' => 'Thêm Tài Xế',
                'routeName' => 'admin.driver.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createDriver'],
            ],
            [
                'title' => 'DS Tài Xế',
                'routeName' => 'admin.driver.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewDriver'],
            ],
            [
                'title' => 'DS Tài Xế Mới',
                'routeName' => 'admin.driver.pendingVerification',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewDriver'],
            ],
            [
                'title' => 'Tỷ lệ chuyến',
                'routeName' => 'admin.driver.orderRate',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewDriver'],
            ]
        ]
    ],

    [
        'title' => 'Sliders',
        'routeName' => null,
        'icon' => '<i class="ti ti-slideshow"></i>',
        'roles' => [],
        'permissions' => ['createSlider', 'viewSlider', 'updateSlider', 'deleteSlider'],
        'sub' => [
            [
                'title' => 'Thêm Sliders',
                'routeName' => 'admin.slider.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createSlider'],
            ],
            [
                'title' => 'DS Sliders',
                'routeName' => 'admin.slider.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewSlider'],
            ],
        ]
    ],
    [
        'title' => 'Vai trò',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-check"></i>',
        'roles' => [],
        'permissions' => ['createRole', 'viewRole', 'updateRole', 'deleteRole'],
        'sub' => [
            [
                'title' => 'Thêm Vai trò',
                'routeName' => 'admin.role.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createRole'],
            ],
            [
                'title' => 'DS Vai trò',
                'routeName' => 'admin.role.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewRole'],
            ]
        ]
    ],
    [
        'title' => 'Admin',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-shield"></i>',
        'roles' => [],
        'permissions' => ['createAdmin', 'viewAdmin', 'updateAdmin', 'deleteAdmin'],
        'sub' => [
            [
                'title' => 'Thêm admin',
                'routeName' => 'admin.admin.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS admin',
                'routeName' => 'admin.admin.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
        ]
    ],
    [
        'title' => 'Cài đặt',
        'routeName' => null,
        'icon' => '<i class="ti ti-settings"></i>',
        'roles' => [],
        'permissions' => ['settingGeneral'],
        'sub' => [
            [
                'title' => 'Chung',
                'routeName' => 'admin.setting.general',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'system_revenue',
                'routeName' => 'admin.setting.system',
                'icon' => '<i class="ti ti-server-cog"></i>',
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'C - Ride',
                'routeName' => 'admin.setting.c_ride',
                'icon' => '<i class="ti ti-motorbike"></i>',
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'C - Car',
                'routeName' => 'admin.setting.c_car',
                'icon' => '<i class="ti ti-car"></i>',
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'C - Delivery',
                'routeName' => 'admin.setting.c_delivery',
                'icon' => '<i class="ti ti-truck-delivery"></i>',
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'C - Intercity',
                'routeName' => 'admin.setting.c_intercity',
                'icon' => '<i class="ti ti-bus"></i>',
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'C - Multi',
                'routeName' => 'admin.setting.c_multi',
                'icon' => '<i class="ti ti-map"></i>',
                'permissions' => ['settingGeneral'],
            ],
        ]
    ],
    [
        'title' => 'Dev: Quyền',
        'routeName' => null,
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => [
            [
                'title' => 'Thêm Quyền',
                'routeName' => 'admin.permission.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ],
            [
                'title' => 'DS Quyền',
                'routeName' => 'admin.permission.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ]
        ]
    ],
    [
        'title' => 'Dev: Module',
        'routeName' => null,
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => [
            [
                'title' => 'Thêm Module',
                'routeName' => 'admin.module.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ],
            [
                'title' => 'DS Module',
                'routeName' => 'admin.module.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ]
        ]
    ],
    [
        'title' => 'Dev: Nghiệm thu',
        'routeName' => 'admin.module.summary',
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => []
    ],

];
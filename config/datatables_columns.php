<?php

return [
    'discount_apply' => [
        'user' => [
            'title' => 'Khách hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'date_start' => [
            'title' => 'Ngày bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'date_end' => [
            'title' => 'Ngày kết thúc',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'value' => [
            'title' => 'Giá trị giảm',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'area' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'fee' => [
            'title' => 'Giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'address' => [
            'title' => 'address',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'shipment' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'user_id' => [
            'title' => 'Khách hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'weight_range_id' => [
            'title' => 'Khoảng cân nặng',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'start_address' => [
            'title' => 'Điểm bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'end_address' => [
            'title' => 'Điểm kết thúc',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'recipient_name' => [
            'title' => 'Tên người nhận',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'recipient_phone' => [
            'title' => 'Số điện thoại người nhận',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'collection_from_sender_status' => [
            'title' => 'Trạng thái lấy hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'advance_payment_status' => [
            'title' => 'Trạng thái thanh toán',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'collect_on_delivery_amount' => [
            'title' => 'Số tiền thu hộ',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'shipment_status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_deleted' => [
            'title' => 'Xoá',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],

        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'reviews' => [
        'user_id' => [
            'title' => 'Khách Hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'order_id' => [
            'title' => 'Đơn Hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'rating' => [
            'title' => 'Đánh Giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'content' => [
            'title' => 'Nội Dung',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
    ],
    'transaction' => [
        'code' => [
            'title' => 'code',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'type' => [
            'title' => 'type',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'weight_range' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'min_weight' => [
            'title' => 'min_weight',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'max_weight' => [
            'title' => 'max_weight',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'notifications' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],

        'driver_id' => [
            'title' => 'Tài xế nhận',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'user_id' => [
            'title' => 'Khách hàng nhận',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'message' => [
            'title' => 'Nội dung',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],

        'created_at' => [
            'title' => 'Ngày thông báo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],

    ],
    'notifications_deposit' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],

        'driver_id' => [
            'title' => 'Tài xế nhận',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'user_id' => [
            'title' => 'Khách hàng nhận',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'message' => [
            'title' => 'Nội dung',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'is_verified' => [
            'title' => 'ADMIN xác nhận',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],

        'created_at' => [
            'title' => 'Ngày thông báo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],

    ],
    'discount' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'code' => [
            'title' => 'Mã',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],

        'users' => [
            'title' => 'user',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'drivers' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'date_start' => [
            'title' => 'Ngày bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'date_end' => [
            'title' => 'Ngày kết thúc',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'max_usage' => [
            'title' => 'Số lượng phiếu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'min_order_amount' => [
            'title' => 'Giá trị ĐH',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'discount_value' => [
            'title' => 'giá trị giảm',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'report_order' => [
        'code' => [
            'title' => 'Mã code đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],

        'users' => [
            'title' => 'Khách hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'drivers' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'description' => [
            'title' => 'Lý do trả hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],

    'vehicle' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'code' => [
            'title' => 'Mã phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'service_type' => [
            'title' => 'Loại dịch vụ',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle_company' => [
            'title' => 'Nhà sản xuất',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'color' => [
            'title' => 'Màu phương tiện',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'type' => [
            'title' => 'Loại xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'license_plate' => [
            'title' => 'Biển số xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'vehicleLines' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => true,
        ],
        'name' => [
            'title' => 'Tên dòng xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'description' => [
            'title' => 'Mô tả',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'module' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên Module',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'role' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'title' => [
            'title' => 'Tên vai trò',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Slug ( role_name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'guard_name' => [
            'title' => 'Vai trò của nhóm ( Guard Name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'permission' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'title' => [
            'title' => 'Tên quyền',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Slug ( Permission_name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'module_id' => [
            'title' => 'Thuộc Module',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'guard_name' => [
            'title' => 'Nhóm quyền ( Guard Name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'admin' => [

        'fullname' => [
            'title' => 'Họ tên',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'roles' => [
            'title' => 'Vai trò',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],

    'driver_cancel_rate' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'name' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'email' => [
            'title' => 'Email',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'total_order' => [
            'title' => 'Tổng số đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'complete' => [
            'title' => 'Hoàn thành',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'complete_rate' => [
            'title' => 'Tỷ lệ hoàn thành',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'cancel' => [
            'title' => 'Hủy',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'cancel_rate' => [
            'title' => 'Tỷ lệ hủy',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'return' => [
            'title' => 'Trả hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'return_rate' => [
            'title' => 'Tỷ lệ trả hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'user' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'fullname' => [
            'title' => 'Họ tên',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'gender' => [
            'title' => 'Giới tính',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'status' => [
            'title' => 'Trạng thái tài khoản',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],

        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'active' => [
            'title' => 'Trạng thái online',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'bank_account_number' => [
            'title' => 'Số tài khoản',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'name' => [
            'title' => 'Tên ngân hàng',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'balance' => [
            'title' => 'Số dư ví',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'order_history' => [
            'title' => 'Lịch sử đơn hàng',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'user_order' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver_id' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'order_type' => [
            'title' => 'Loại đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
    ],
    'store' => [
        'priority' => [
            'title' => 'priority',
            'addClass' => 'text-center align-middle',
            'orderable' => true
        ],
        'store_name' => [
            'title' => 'storeName',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'category' => [
            'title' => 'category2',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'area' => [
            'title' => 'area',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'open_hours_1' => [
            'title' => 'operatingTime',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'status' => [
            'title' => 'status',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'address_detail' => [
            'title' => 'address',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'created_at' => [
            'title' => 'createdAt',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'store_category' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'store_product' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'view-topping' => [
            'title' => 'Topping',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'view-discount' => [
            'title' => 'Discount',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'product_topping' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'category' => [
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'align-middle text-center'
        ],
        'description' => [
            'title' => 'Mô tả',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle text-center'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'attribute' => [
        'position' => [
            'title' => 'Vị trí',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'name' => [
            'title' => 'Tên thuộc tính',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'variations' => [
            'title' => 'Các biến thể',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'attributes_variations' => [
        'position' => [
            'title' => 'Vị trí',
            'orderable' => false,
        ],
        'name' => [
            'title' => 'Tên biến thể',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'desc' => [
            'title' => 'Mô tả',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'product' => [
        'avatar' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'in_stock' => [
            'title' => 'Kho',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'price' => [
            'title' => 'Giá',
            'width' => '150px',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'categories' => [
            'title' => 'Danh mục',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'toppings' => [
            'title' => 'Topping',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'order' => [
        'id' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_code' => [
            'title' => 'Mã thanh toán',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'order_type' => [
            'title' => 'Loại hợp đồng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày đặt',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'driver-routes' => [
        'id' => [
            'title' => 'Id',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'start_address' => [
            'title' => 'Điểm bắt đầu',
            'orderable' => false,
        ],
        'start_lat' => [
            'title' => 'Vĩ độ bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'start_lng' => [
            'title' => 'Kinh độ bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'end_address' => [
            'title' => 'Điểm kết thúc',
            'orderable' => false,
        ],
        'end_lat' => [
            'title' => 'Vĩ độ kết thúc',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
            'visible' => false,
        ],
        'end_lng' => [
            'title' => 'Kinh độ kết thúc',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'price' => [
            'title' => 'Giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'return_price' => [
            'title' => 'Giá khứ hồi',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'routes' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'id' => [
            'title' => 'Id',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'start_address' => [
            'title' => 'Điểm bắt đầu',
            'orderable' => false,
        ],
        'end_address' => [
            'title' => 'Điểm kết thúc',
            'orderable' => false,
        ],
        'price' => [
            'title' => 'Giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'return_price' => [
            'title' => 'Giá khứ hồi',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'route_variant' => [
            'title' => 'Phục vụ',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'c-ride-car' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle' => [
            'title' => 'Phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
        ],
        'order_type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'c-delivery' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle' => [
            'title' => 'Phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
        ],
        'order_type' => [
            'title' => 'Loại',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'delivery_date' => [
            'title' => 'delivery_date',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'delivery_time' => [
            'title' => 'delivery_time',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'shippingWeightRange' => [
            'title' => 'Trọng lượng',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'c-intercity' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle' => [
            'title' => 'Phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
            'visible' => false,
        ],
        'order_type' => [
            'title' => 'Loại',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'start_date' => [
            'title' => 'start_date',
            'orderable' => false,
            'addClass' => 'text-center align-middle',

        ],
        'departure_time' => [
            'title' => 'departure_time',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'end_date' => [
            'title' => 'Ngày về',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'return_time' => [
            'title' => 'return_time',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'trip_type' => [
            'title' => 'trip_type',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'c-multi' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle' => [
            'title' => 'Phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false,
        ],

        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
            'visible' => false,
        ],
        'order_type' => [
            'title' => 'Loại',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'slider' => [
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'plain_key' => [
            'title' => 'Key',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'items' => [
            'title' => 'Slider Item',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'slider_item' => [
        'title' => [
            'title' => 'Tên',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'image' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'position' => [
            'title' => 'Vị trí',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'post_category' => [
        'avatar' => [
            'title' => 'avatar',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'post' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'image' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_featured' => [
            'title' => 'Nổi bật',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
    ],
    'pending_driver' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => true,
        ],
        'fullname' => [
            'title' => 'fullname',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'id_card' => [
            'title' => 'id_card',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'order_status' => [
            'title' => 'Trạng thái nhận đơn',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'auto_accept' => [
            'title' => 'Tự động nhận chuyến',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái tài khoản',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_verified' => [
            'title' => 'Admin xác nhận',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],

        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'driver' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'fullname' => [
            'title' => 'fullname',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'id_card' => [
            'title' => 'id_card',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'email' => [
            'title' => 'Email',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false,
        ],
        'name' => [
            'title' => 'Tên ngân hàng',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],

        'balance' => [
            'title' => 'Số dư ví',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'order_status' => [
            'title' => 'Trạng thái nhận đơn',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'auto_accept' => [
            'title' => 'Tự động nhận chuyến',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'status' => [
            'title' => 'Trạng thái tài khoản',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'discount' => [
            'title' => 'Mã giảm giá',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'orderCRideCar' => [
            'title' => 'Chuyến đi',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'review' => [
            'title' => 'Đánh giá',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'orders' => [
            'title' => 'Lịch sử đơn hàng',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'order_by_driver' => [
        'code' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'user' => [
            'title' => 'Khách hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'order_type' => [
            'title' => 'Loại đơn hàng',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'trip_type' => [
            'title' => 'trip_type',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
    ],
    'driver_discount' => [
        'code' => [
            'title' => 'Mã',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'date_start' => [
            'title' => 'Ngày bắt đầu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'date_end' => [
            'title' => 'Ngày kết thúc',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'max_usage' => [
            'title' => 'Số lượng phiếu',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'min_order_amount' => [
            'title' => 'Giá trị ĐH',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'discount_value' => [
            'title' => 'giá trị giảm',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'holiday' => [
        'checkbox' => [
            'title' => 'choose',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'align-middle text-center',
            'footer' => '<input type="checkbox" class="form-check-input check-all" />',
            'visible' => false,
        ],
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'date' => [
            'title' => 'Ngày lễ',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'category_system' => [
        'name' => [
            'title' => 'Tên dịch vụ',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'avatar' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'width' => '150px',
            'visible' => true
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],

    ],

];

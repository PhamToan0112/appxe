<?php

return [
    'new_order' => [
        'title' => 'Đơn Hàng Mới',
        'message' => 'Một đơn hàng {order_code} mới đã được đặt',
    ],
    'order_status_pending' => [
        'title' => 'Cập nhật trạng thái đơn hàng',
        'message' => 'Đơn hàng {order_code} đang chờ xác nhận',
    ],
    'order_status_delivering' => [
        'title' => 'Cập nhật trạng thái đơn hàng',
        'message' => 'Đơn hàng {order_code} đang được vận chuyển đến bạn.',
    ],
    'order_status_delivered' => [
        'title' => 'Cập nhật trạng thái đơn hàng',
        'message' => 'Đơn hàng {order_code} đã đến điểm giao.',
    ],
    'order_status_completed' => [
        'title' => 'Cập nhật trạng thái đơn hàng',
        'message' => 'Đơn hàng {order_code} đã giao thành công.',
    ],
    'customer_declined_driver' => [
        'title' => 'Khách hàng đã từ chối tài xế',
        'message' => 'Khách hàng {customer_name} đã từ chối bạn. Vui lòng chờ khách hàng khác hoặc tìm kiếm yêu cầu mới.'
    ],
    'driver_confirmed_order' => [
        'title' => 'Tài xế đã xác nhận',
        'message' => 'Tài xế đã chấp nhận yêu cầu đặt xe, sẽ đến đón bạn trong ít phút! Vui lòng chú ý điện thoại',
    ],
    'driver_declined_order' => [
        'title' => 'Tài xế đã từ chối',
        'message' => 'Tài xế {driver_name} đã từ chối yêu cầu đặt xe của bạn, vui lòng tìm tài xế khác',
    ],
    'driver_selected_customer' => [
        'title' => 'Có tài xế chọn bạn!',
        'message' => 'Tài xế {driver_name} đã nhận chuyến với mức giá bạn mong muốn, nhấn chấp nhận để bắt đầu chuyến đi'
    ],

    'request_deposit_confirmation' => [
        'title' => 'Yêu Cầu Xác Nhận Nạp Tiền',
        'message' => 'Yêu cầu nạp tiền của bạn đã được ghi nhận. Vui lòng chờ ADMIN duyệt'
    ],
    'successful_deposit_confirmation' => [
        'title' => 'Nạp Tiền Thành Công',
        'message' => 'Bạn đã nạp thành công số tiền +{amount} vào tài khoản của bạn.'
    ],

    'successful_confirmation' => [
        'title' => 'Đã xác nhận',
        'message' => 'Yêu cầu xác nhận của bạn đã được ADMIN DUYỆT.'
    ],

    'request_withdrawal_confirmation' => [
        'title' => 'Yêu Cầu Xác Nhận Rút Tiền',
        'message' => 'Yêu cầu rút tiền của bạn đã được ghi nhận. Vui lòng chờ ADMIN duyệt'
    ],
    'successful_withdrawal_confirmation' => [
        'title' => 'Rút Tiền Thành Công',
        'message' => 'Bạn đã rút thành công số tiền -{amount} từ tài khoản của bạn.'
    ],
    'successful_payment_confirmation' => [
        'title' => 'Thanh Toán Thành Công',
        'message' => 'Bạn đã thanh toán thành công số tiền {amount}.'
    ],
    'order_completed_success' => [
        'title' => 'Đơn Hàng Hoàn Thành',
        'message' => 'Đơn hàng {order_code} đã được hoàn thành thành công. Bạn đã nhận được số tiền {amount}.'
    ],
    'driver_reconfirm_order' => [
        'title' => 'Tài xế đã nhận đơn',
        'message' => 'Tài xế đã nhận đơn, tài xế sẽ liên hệ lại bạn để xác nhận đơn hàng'
    ],
    'driver_on_way_to_pick_up' => [
        'title' => 'Tài xế đang tới lấy hàng',
        'message' => 'Tài xế đang trên đường tới để lấy hàng đơn hàng {order_code}. Vui lòng chuẩn bị sẵn sàng để giao hàng.'
    ],
    'order_hold_confirmation' => [
        'title' => 'Số Tiền Được Tạm Giữ',
        'message' => 'Một khoản tiền {amount} đã được tạm giữ cho đơn hàng {order_code} của bạn. Số tiền này sẽ được giải phóng sau khi giao dịch hoàn tất.'
    ],

    'customer_canceled_order' => [
        'title' => 'Khách hàng đã hủy đơn hàng',
        'message' => 'Khách hàng đã hủy đơn {order_code}.'
    ],
    'customer_accepted_order' => [
        'title' => 'Khách hàng đã xác nhận đơn hàng',
        'message' => 'Khách hàng {customer_name} đã xác nhận nhận đơn hàng {order_code}. Vui lòng chuẩn bị!.',
    ],
    'driver_canceled_order' => [
        'title' => 'Tài xế đã hủy đơn hàng',
        'message' => 'Tài xế đã hủy đơn {order_code}.'
    ],
    'driver_reported' => [
        'title' => 'Báo cáo vi phạm của tài xế',
        'message' => 'Tài xế {driver_name} đã bị báo cáo vì vi phạm quy tắc dịch vụ trong đơn hàng {order_code}. Vui lòng xem xét và xử lý sự việc.'
    ],
    'discount' => [
        'title' => 'Mã giảm giá mới',
        'message' => 'Bạn vừa nhận được một mã giảm giá mới từ hệ thống.'
    ],
    'pending_confirm' => [
        'title' => 'Chờ {type} xác nhận',
        'message' => 'Đơn hàng {order_code} đang chờ {type} xác nhận.'
    ],
    'order_confirmed' => [
        'title' => 'Đơn hàng đã được xác nhận',
        'message' => 'Đơn hàng {order_code} đã được {type} xác nhận.'
    ],
    'order_declined' => [
        'title' => 'Đơn hàng đã bị từ chối',
        'message' => 'Đơn hàng {order_code} đã bị {type} từ chối.'
    ],
    'inTransitOrder_user' => [
        'title' => 'Đơn hàng {order_code}',
        'message' => 'Đơn hàng của bạn đã bắt đầu. Hãy theo dõi lộ trình trên ứng dụng.'
    ],
    'inTransitOrder_driver' => [
        'title' => 'Đơn hàng {order_code}',
        'message' => 'Bạn đang trong chuyến hành trình. Hãy lái xe an toàn.'
    ],
    'completedOrder_user' => [
        'title' => 'Đơn hàng {order_code} ',
        'message' => 'Đơn hàng đã hoàn thành. Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.'
    ],
    'completedOrder_driver' => [
        'title' => 'Đơn hàng {order_code} ',
        'message' => 'Đơn hàng đã hoàn thành. Cảm ơn bạn đã lái xe an toàn.'
    ],
    'cancelOrder' => [
        'title' => 'Đơn hàng đã bị hủy',
        'message' => 'Đơn hàng {order_code} đã bị hủy. Vui lòng liên hệ với bộ phận hỗ trợ nếu có thắc mắc.'
    ],
    'cancelOrder_type' => [
        'title' => 'Đơn hàng đã bị hủy',
        'message' => '{type} đã hủy đơn hàng {order_code}.'
    ],
    'onwayPickUpOrder' => [
        'title' => 'Tài xế đang tới lấy hàng',
        'message' => 'Tài xế đang trên đường tới để lấy đơn hàng {order_code}. Vui lòng chuẩn bị sẵn sàng để giao hàng.'
    ],
    'returnedOrder' => [
        'title' => 'Đơn hàng đã được trả lại',
        'message' => 'Đơn hàng {order_code} đã được hoàn trả. Vui lòng liên hệ với bộ phận hỗ trợ nếu có thắc mắc.'
    ],
    'driver_on_the_move' => [
        'title' => 'Tài xế đang di chuyển',
        'message' => 'Tài xế thuộc đơn hàng {order_code} đang trên đường đến địa điểm của bạn. Vui lòng chuẩn bị sẵn sàng.',
    ],
    'driver_wants_to_take_order' => [
        'title' => 'Có tài xế chọn bạn',
        'message' => 'Tài xế {driver_name} muốn nhận đơn hàng {order_code}. Vui lòng xác nhận hoặc từ chối yêu cầu này.',
    ],

];

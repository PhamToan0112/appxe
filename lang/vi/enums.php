<?php

use App\Enums\Area\AreaStatus;
use App\Enums\DefaultStatus;
use App\Enums\DeleteStatus;
use App\Enums\Discount\DiscountOption;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\FeaturedStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderCDeliveryStatus;
use App\Enums\Order\OrderCIntercityStatus;
use App\Enums\Order\OrderCMultiStatus;
use App\Enums\Order\OrderCRideCarStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\PaymentRole;
use App\Enums\Order\ShippingProgressStatus;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\Post\PostStatus;
use App\Enums\Module\ModuleStatus;
use App\Enums\Notification\MessageType;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\Order\OrderType;
use App\Enums\Order\OrderMultiPointStatus;
use App\Enums\PriorityStatus;
use App\Enums\Service\ServiceStatus;
use App\Enums\Shipment\ShipmentStatus;
use App\Enums\Transaction\TransactionType;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Vehicle\LicensePlateColor;
use App\Enums\Vehicle\VehicleType;
use App\Enums\VerifiedStatus;
use App\Enums\Product\{ProductInStock, ProductManagerStock, ProductStatus};
use App\Enums\Setting\SettingGroup;
use App\Enums\Slider\SliderStatus;
use App\Enums\ActiveStatus;
use App\Enums\Address\AddressType;
use App\Enums\User\{
    CostStatus,
    DiscountSortStatus,
    DistanceStatus,
    Gender,
    RatingSortStatus,
    TimeStatus,
    UserStatus,
    UserVip,
    UserRoles,
    UserActive,
};
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Driver\DriverReviews;
use App\Enums\Review\ReviewStatus;

return [
    DiscountOption::class => [
        DiscountOption::None->value => 'Không áp dụng',
        DiscountOption::All->value => 'Áp dụng cho tất cả',
        DiscountOption::One->value => 'Áp dụng cho một người cụ thể',
    ],
    OrderMultiPointStatus::class => [
        OrderMultiPointStatus::Pending->value => 'Đang chờ',
        OrderMultiPointStatus::Delivering->value => 'Đang giao',
        OrderMultiPointStatus::Delivered->value => 'Đã đến',
        OrderMultiPointStatus::Completed->value => 'Đã giao',
    ],
    ShippingProgressStatus::class => [
        ShippingProgressStatus::Pending->value => 'Đang chờ xử lý',
        ShippingProgressStatus::InProgress->value => 'Đang giao hàng',
        ShippingProgressStatus::Delivered->value => 'Giao hàng thành công',
        ShippingProgressStatus::Returned->value => 'Đã trả hàng',
    ],
    DeleteStatus::class => [
        DeleteStatus::Deleted->value => 'Đã xóa',
        DeleteStatus::NotDeleted->value => 'Chưa xóa',
    ],
    ShipmentStatus::class => [
        ShipmentStatus::Preparing->value => 'Đang chuẩn bị',
        ShipmentStatus::Draft->value => 'Bản nháp',
        ShipmentStatus::Deleted->value => 'Đã xóa',
        ShipmentStatus::Unsorted->value => 'Chưa phân loại',
        ShipmentStatus::Ordered->value => 'Đã lên đơn',
    ],
    AddressType::class => [
        AddressType::HOME->value => 'Nhà riêng',
        AddressType::WORK->value => 'Cơ quan',
        AddressType::SCHOOL->value => 'Trường học',
        AddressType::OTHER->value => 'Khác',
    ],
    ActiveStatus::class => [
        ActiveStatus::Active->value => 'Hoạt động',
        ActiveStatus::Deleted->value => 'Đã xóa',
        ActiveStatus::Draft->value => 'Bản nháp',
    ],
    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
    ],
    ReviewStatus::class => [
        ReviewStatus::Active->value => 'Đã xác nhận',
        ReviewStatus::Pending->value => 'Chờ xác nhận',
        ReviewStatus::Deleted->value => 'Không được xác nhận',
    ],
    NotificationStatus::class => [
        NotificationStatus::READ->value => 'Đã đọc',
        NotificationStatus::NOT_READ->value => 'Chưa đọc',
    ],
    ServiceStatus::class => [
        ServiceStatus::On->value => 'Đang hoạt động',
        ServiceStatus::Off->value => 'Không hoạt động',
    ],
    VerificationStatus::class => [
        VerificationStatus::Verified->value => 'Đã xác nhận',
        VerificationStatus::Unverified->value => 'Chưa xác nhận',
        VerificationStatus::Cancelled->value => 'Huỷ bỏ',
    ],
    LicensePlateColor::class => [
        LicensePlateColor::White->value => 'Biển trắng',
        LicensePlateColor::Yellow->value => 'Biển vàng',
    ],
    NotificationOption::class => [
        NotificationOption::All->value => 'Cho tất cả',
        NotificationOption::One->value => 'Cho một người',
    ],
    MessageType::class => [
        MessageType::UNCLASSIFIED->value => 'Không phân loại',
        MessageType::DEPOSIT->value => 'Thông báo nạp tiền',
        MessageType::WITHDRAW->value => 'Thông báo rút tiền',
        MessageType::PAYMENT->value => 'Thanh toán',
        MessageType::PAYMENT->value => 'Thanh toán',
        MessageType::TEMPORARY_HOLD->value => 'Tạm giữ',
        MessageType::REPORT->value => 'Báo cáo',
    ],
    NotificationType::class => [
        NotificationType::All->value => 'Thông báo tất cả',
        NotificationType::Driver->value => 'Thông báo tài xế',
        NotificationType::Customer->value => 'Thông báo khách hàng',
    ],
    ProductStatus::class => [
        ProductStatus::Active->value => 'Đang hoạt động',
        ProductStatus::InActive->value => 'Ngưng hoạt động',
    ],
    ProductManagerStock::class => [
        ProductManagerStock::Managed->value => 'Có quản lý',
        ProductManagerStock::NotManaged->value => 'Không quản lý',
    ],
    ProductInStock::class => [
        ProductInStock::InStock->value => 'Còn hàng',
        ProductInStock::OutOfStock->value => 'Hết hàng',
    ],
    VehicleType::class => [
        VehicleType::Motorcycle->value => 'Xe 2 bánh',
        VehicleType::Car4->value => 'C-Car(4 chỗ)',
        VehicleType::Car7->value => 'C-Car(7 chỗ)'
    ],
    AutoAccept::class => [
        AutoAccept::Auto->value => 'Tự động nhận chuyến',
        AutoAccept::Off->value => 'Tắt tự động nhận chuyến',
        AutoAccept::Locked->value => 'Khoá tự động nhận chuyến',
    ],

    PaymentMethod::class => [
        PaymentMethod::Wallet->value => 'Wallet',
        PaymentMethod::Direct->value => 'Trực tiếp',
    ],
    DriverOrderStatus::class => [
        DriverOrderStatus::NotReceived->value => 'Đang chờ đơn',
        DriverOrderStatus::Received->value => 'Đã nhận đơn',
        DriverOrderStatus::InTransit->value => 'Đang chuyển đơn',
        DriverOrderStatus::PendingConfirmation->value => 'Đang chờ xác nhận đơn',
    ],
    DriverStatus::class => [
        DriverStatus::Active->value => 'Hoạt động',
        DriverStatus::PendingConfirmation->value => 'Chờ xác nhận',
        DriverStatus::Lock->value => 'Đã khoá',
        DriverStatus::Inactive->value => 'Không hoạt động',
    ],
    DriverReviews::class => [
        DriverReviews::Bad->value => 'Tiêu Cực',
        DriverReviews::Good->value => 'Tích Cực',
    ],

    VehicleStatus::class => [
        VehicleStatus::Pending->value => 'Chờ xác nhận',
        VehicleStatus::Active->value => 'Hoạt động',
        VehicleStatus::Inactive->value => 'Không hoạt động',
        VehicleStatus::Deleted->value => 'Đã xóa',
        VehicleStatus::UnderMaintenance->value => 'Đang bảo trì',
    ],
    UserVip::class => [
        UserVip::Default => 'Mặc định',
        UserVip::Bronze => 'Đồng',
        UserVip::Silver => 'Bạc',
        UserVip::Gold => 'Vàng',
        UserVip::Diamond => 'Kim cương',
    ],
    UserRoles::class => [
        UserRoles::Customer->value => 'Khách hàng',
        UserRoles::Driver->value => 'Tài xế',
    ],
    UserActive::class => [
        UserActive::Active->value => 'Xác nhận',
    ],
    UserStatus::class => [
        UserStatus::Active->value => 'Hoạt động',
        UserStatus::PendingConfirmation->value => 'Chờ xác nhận',
        UserStatus::Lock->value => 'Đã khoá',
        UserStatus::Inactive->value => 'Không hoạt động',
    ],

    DefaultStatus::class => array(
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp',
        DefaultStatus::Deleted->value => 'Đã xoá',
    ),
    AreaStatus::class => array(
        AreaStatus::On->value => 'Hoạt động',
        AreaStatus::Off->value => 'Không hoạt động'
    ),

    OrderStatus::class => [
        OrderStatus::Pending->value => 'Chờ xác nhận',
        OrderStatus::PendingDriverConfirmation->value => 'Chờ tài xế xác nhận',
        OrderStatus::PendingCustomerConfirmation->value => 'Chờ khách hàng xác nhận',
        OrderStatus::Confirmed->value => 'Đã xác nhận',
        OrderStatus::DriverConfirmed->value => 'Tài xế đã xác nhận',
        OrderStatus::CustomerConfirmed->value => 'Khách hàng đã xác nhận',
        OrderStatus::InTransit->value => 'Đang di chuyển',
        OrderStatus::ArrivedAtStore->value => 'Đã đến cửa hàng',
        OrderStatus::MovingToDestination->value => 'Đang di chuyển đến điểm đến',
        OrderStatus::Completed->value => 'Hoàn thành',
        OrderStatus::Cancelled->value => 'Hủy bỏ',
        OrderStatus::Failed->value => 'Không thành công',
        OrderStatus::Returned->value => 'Đã trả hàng',
        OrderStatus::Preparing->value => 'Đang chuẩn bị',
        OrderStatus::Draft->value => 'Bản nháp',
        OrderStatus::Canceled->value => 'Đã hủy',
        OrderStatus::DriverDeclined->value => 'Tài xế đã từ chối',
        OrderStatus::CustomerDeclined->value => 'Khách hàng đã từ chối',
        OrderStatus::PickingUp->value => 'Đang đến lấy hàng',
        OrderStatus::DriverCanceled->value => 'Tài xế đã hủy đơn',
        OrderStatus::CustomerCanceled->value => 'Khách hàng đã hủy đơn',
    ],

    OrderType::class => [
        OrderType::C_RIDE->value => 'C_RIDE',
        OrderType::C_CAR->value => 'C_CAR',
        OrderType::C_Intercity->value => 'C_Intercity',
        OrderType::C_Delivery->value => 'C_Delivery',
        OrderType::C_Multi->value => 'C_Multi',
    ],
    PaymentRole::class => [
        PaymentRole::RECIPIENT->value => 'Người gửi thanh toán',
        PaymentRole::SENDER->value => 'Người nhận thanh toán',
    ],
    DeliveryStatus::class => [
        DeliveryStatus::IMMEDIATE->value => 'Giao hàng ngay',
        DeliveryStatus::SCHEDULED->value => 'Giao hàng hẹn giờ',
    ],

    OrderCRideCarStatus::class => [
        OrderCRideCarStatus::Pending->value => 'Chờ xác nhận',
        OrderCRideCarStatus::PendingDriverConfirmation->value => 'Chờ tài xế xác nhận',
        OrderCRideCarStatus::PendingCustomerConfirmation->value => 'Chờ khách hàng xác nhận',
        OrderCRideCarStatus::DriverConfirmed->value => 'Tài xế đã xác nhận',
        OrderCRideCarStatus::CustomerConfirmed->value => 'Khách hàng đã xác nhận',
        OrderCRideCarStatus::DriverDeclined->value => 'Tài xế đã từ chối',
        OrderCRideCarStatus::CustomerDeclined->value => 'Khách hàng đã từ chối',
        OrderCRideCarStatus::InTransit->value => 'Đang di chuyển',
        OrderCRideCarStatus::Completed->value => 'Hoàn thành',
        OrderCRideCarStatus::DriverCanceled->value => 'Tài xế huỷ đơn',
        OrderCRideCarStatus::CustomerCanceled->value => 'Khách hàng huỷ đơn',
    ],

    OrderCDeliveryStatus::class => [
        OrderCDeliveryStatus::PendingDriverConfirmation->value => 'Chờ tài xế xác nhận',
        OrderCDeliveryStatus::PendingCustomerConfirmation->value => 'Chờ khách hàng xác nhận',
        OrderCDeliveryStatus::DriverConfirmed->value => 'Tài xế đã xác nhận',
        OrderCDeliveryStatus::PickingUp->value => 'Đang đến lấy hàng',
        OrderCDeliveryStatus::CustomerConfirmed->value => 'Khách hàng đã xác nhận',
        OrderCDeliveryStatus::DriverDeclined->value => 'Tài xế đã từ chối',
        OrderCDeliveryStatus::CustomerDeclined->value => 'Khách hàng đã từ chối',
        OrderCDeliveryStatus::InTransit->value => 'Đang giao hàng',
        OrderCDeliveryStatus::Completed->value => 'Hoàn thành',
        OrderCDeliveryStatus::Returned->value => 'Đã trả hàng',
        OrderCDeliveryStatus::DriverCanceled->value => 'Tài xế huỷ đơn',
        OrderCDeliveryStatus::CustomerCanceled->value => 'Khách hàng huỷ đơn',
    ],

    OrderCIntercityStatus::class => [
        OrderCIntercityStatus::PendingDriverConfirmation->value => 'Chờ tài xế xác nhận',
        OrderCIntercityStatus::DriverConfirmed->value => 'Tài xế đã xác nhận',
        OrderCIntercityStatus::DriverDeclined->value => 'Tài xế đã từ chối',
        OrderCIntercityStatus::Completed->value => 'Hoàn thành',
        OrderCIntercityStatus::DriverCanceled->value => 'Tài xế huỷ đơn',
        OrderCIntercityStatus::CustomerCanceled->value => 'Khách hàng huỷ đơn',
    ],
    OrderCMultiStatus::class => [
        OrderCMultiStatus::Pending->value => 'Đang chờ',
        OrderCMultiStatus::Preparing->value => 'Chuẩn bị',
        OrderCMultiStatus::Draft->value => 'Bản nháp',
        OrderCMultiStatus::Confirmed->value => 'Đã lên đơn',
        OrderCMultiStatus::DriverCanceled->value => 'Tài xế huỷ đơn',
        OrderCMultiStatus::CustomerCanceled->value => 'Khách hàng huỷ đơn',
    ],


    SliderStatus::class => [
        SliderStatus::Active => 'Hoạt động',
        SliderStatus::Inactive => 'Ngưng hoạt động'
    ],

    TripType::class => [
        TripType::ONE_WAY->value => 'Thường',
        TripType::ROUND_TRIP->value => 'Khứ hồi'
    ],

    DiscountType::class => [
        DiscountType::Money->value => 'Tiền',
        DiscountType::Percent->value => 'Phần trăm'
    ],
    SettingGroup::class => [
        SettingGroup::General => 'Chung',
        SettingGroup::UserDiscount => 'Chiết khấu mua hàng theo cấp TV',
        SettingGroup::UserUpgrade => 'SL SP nâng cấp TV',
    ],
    PostCategoryStatus::class => [
        PostCategoryStatus::Published => 'Đã xuất bản',
        PostCategoryStatus::Draft => 'Bản nháp'
    ],
    PostStatus::class => [
        PostStatus::Published->value => 'Đã xuất bản',
        PostStatus::Draft->value => 'Bản nháp'
    ],
    PriorityStatus::class => [
        PriorityStatus::Priority->value => 'Ưu tiên',
        PriorityStatus::NotPriority->value => 'Không ưu tiên'
    ],
    FeaturedStatus::class => [
        FeaturedStatus::Featured->value => 'Nổi bật',
        FeaturedStatus::Featureless->value => 'Không nổi bật'
    ],
    ModuleStatus::class => [
        ModuleStatus::ChuaXong => 'Chưa xong',
        ModuleStatus::DaXong => 'Đã xong',
        ModuleStatus::DaDuyet => 'Đã duyệt'
    ],
    TransactionType::class => [
        TransactionType::Deposit->value => 'Nạp tiền',
        TransactionType::Withdraw->value => 'Rút tiền',
        TransactionType::Payment->value => 'Thanh toán',

    ],
    TransactionStatus::class => [
        TransactionStatus::DELETED->value => 'Đã xóa',
        TransactionStatus::NOT_DELETED->value => 'Chưa xóa',
    ],

    CostStatus::class => [
        CostStatus::Lowest->value => 'Thấp nhất',
        CostStatus::Highest->value => 'Cao nhất'
    ],
    TimeStatus::class => [
        TimeStatus::Newest->value => 'Mới nhất',
        TimeStatus::Oldest->value => 'Cũ nhất'
    ],
    RatingSortStatus::class => [
        RatingSortStatus::Highest->value => 'Cao nhất',
        RatingSortStatus::Lowest->value => 'Thấp nhất'
    ],
    DiscountSortStatus::class => [
        DiscountSortStatus::Most->value => 'Nhiều nhất',
        DiscountSortStatus::Least->value => 'Ít nhất'
    ],
    DistanceStatus::class => [
        DistanceStatus::Nearest->value => 'Gần nhất',
        DistanceStatus::Farthest->value => 'Xa nhất'
    ],
    DiscountStatus::class => [
        DiscountStatus::Published->value => 'Đã xuất bản',
        DiscountStatus::Draft->value => 'Bản nháp',
        DiscountStatus::Inactive->value => 'Không hoạt động',
    ],
    VerifiedStatus::class => [
        VerifiedStatus::Active->value => 'Đã xác nhận',
        VerifiedStatus::Pending->value => 'Chờ xác nhận',

    ],
    OpenStatus::class => [
        OpenStatus::ON->value => 'Mở',
        OpenStatus::OFF->value => 'Tắt',

    ],
];

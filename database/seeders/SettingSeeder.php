<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Setting\SettingTypeInput;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'setting_key' => 'site_name',
                'setting_name' => 'Tên site',
                'plain_value' => 'Site name',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Tên của website, shop, app',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'site_logo',
                'setting_name' => 'Logo',
                'plain_value' => '/public/assets/images/logo.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General,
                'desc' => 'Logo thương hiệu',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'email',
                'setting_name' => 'Email',
                'plain_value' => 'mevivu@gmail.com',
                'type_input' => SettingTypeInput::Email,
                'group' => SettingGroup::General,
                'desc' => 'Email liên hệ',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'hotline',
                'setting_name' => 'Số điện thoại',
                'plain_value' => '0999999999',
                'type_input' => SettingTypeInput::Phone,
                'group' => SettingGroup::General,
                'desc' => 'Số điện thoại liên lạc.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'address',
                'setting_name' => 'Địa chỉ',
                'plain_value' => '998/42/15 Quang Trung, GV',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Địa chỉ liên lạc.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bank_name',
                'setting_name' => 'Tên ngân hàng',
                'plain_value' => 'BIDV',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Tên ngân hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bank_account',
                'setting_name' => 'Số tài khoản ngân hàng',
                'plain_value' => '0999999999',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General,
                'desc' => 'Số tài khoản ngân hàng.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'account_holder',
                'setting_name' => 'Chủ tài khoản',
                'plain_value' => 'MeVivu',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Chủ tài khoản.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'qr_code',
                'setting_name' => 'Mã QR',
                'plain_value' => '/public/assets/images/qr_code.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General,
                'desc' => 'Mã QR.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'payment_syntax',
                'setting_name' => 'Cú pháp nạp tiền',
                'plain_value' => 'TX00001_NAPTEN',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Cú pháp nạp tiênd.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'introduce',
                'setting_name' => 'Giới thiệu',
                'plain_value' => 'Chào các bạn, chúng tôi là Mevivu',
                'type_input' => SettingTypeInput::Textarea,
                'group' => SettingGroup::General,
                'desc' => 'Chào các bạn, chúng tôi là Mevivu.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'policy',
                'setting_name' => 'Điều khoản',
                'plain_value' => 'Nhập điều khoản ở đây',
                'type_input' => SettingTypeInput::Textarea,
                'group' => SettingGroup::General,
                'desc' => 'Chào các bạn, chúng tôi là Mevivu.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'clause',
                'setting_name' => 'Chính sách',
                'plain_value' => 'Nhập Chính sách ở đây',
                'type_input' => SettingTypeInput::Textarea(),
                'group' => SettingGroup::General,
                'desc' => 'Chào các bạn, chúng tôi là Mevivu.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'rush_hour_price',
                'setting_name' => 'Phí giờ cao điểm',
                'plain_value' => 10000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::System,
                'desc' => 'Phí tăng thêm',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'holiday_price',
                'setting_name' => 'Phí giờ ngày lễ',
                'plain_value' => 10000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::System,
                'desc' => 'Phí tăng thêm',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'night_price',
                'setting_name' => 'Phí ban đêm ( Sau 23:00)',
                'plain_value' => 10000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::System,
                'desc' => 'Phí tăng thêm',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'enable_platform_fee_C_Ride',
                'setting_name' => 'Bật/Tắt phí nền tảng C - Ride',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Checkbox,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Bật hoặc tắt phí nền tảng cho C - Ride.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_ride_price',
                'setting_name' => 'Phí cơ bản C - Ride',
                'plain_value' => 25000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Phí cơ bản ( Giá tham khảo 25.000 vnđ/ km)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'enable_platform_fee_C_Car',
                'setting_name' => 'Bật/Tắt phí nền tảng C - Car',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Checkbox,
                'group' => SettingGroup::C_Car,
                'desc' => 'Bật hoặc tắt phí nền tảng cho C - Car.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_car_price',
                'setting_name' => 'Phí cơ bản C - Car',
                'plain_value' => 42500,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Car,
                'desc' => 'Phí cơ bản ( Giá tham khảo 42.500 vnđ/ km)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'enable_platform_fee_C_Delivery',
                'setting_name' => 'Bật/Tắt phí nền tảng C - Delivery',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Checkbox,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Bật hoặc tắt phí nền tảng cho C - Delivery.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_price',
                'setting_name' => 'Phí cơ bản C - Delivery',
                'plain_value' => 31620,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Phí cơ bản C - Delivery Now & Later ( Giá tham khảo 31.620 vnđ/ km)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_price_1',
                'setting_name' => 'C - Delivery theo khối lượng Từ 0 - 5 kg',
                'plain_value' => 0,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Từ 0 - 5 kg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_price_2',
                'setting_name' => 'C - Delivery theo khối lượng Từ 5 - 10 kg',
                'plain_value' => 0,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Từ 5 - 10 kg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_price_3',
                'setting_name' => 'C - Delivery theo khối lượng Từ 10 - 20 kg',
                'plain_value' => 0,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Từ 10 - 20 kg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_price_4',
                'setting_name' => 'C - Delivery theo khối lượng Từ 20 - 30 kg',
                'plain_value' => 0,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Từ 20 - 30 kg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_Delivery_multi-location',
                'setting_name' => 'Phí giao hàng đa địa điểm',
                'plain_value' => 99000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Phí giao hàng đa địa điểm giá tham khảo 99.000 vnd',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'fee_per_point',
                'setting_name' => 'Cước phí mỗi điểm',
                'plain_value' => 15000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Cước phí mỗi điểm giá tham khảo 15.000 vnd',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'enable_platform_fee_C_intercity',
                'setting_name' => 'Bật/Tắt phí nền tảng C - Intercity',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Checkbox,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Bật hoặc tắt phí nền tảng cho C - Intercity.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'reference_price',
                'setting_name' => 'Giá tham khảo',
                'plain_value' => 100000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Giá tham khảo 100.000 vnd/người',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'round_trip_price',
                'setting_name' => 'Giá khứ hồi',
                'plain_value' => 100000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Giá khứ hồi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'system_commission_rate_alt',
                'setting_name' => 'Tỉ lệ phần trăm hệ thống nhận được / đơn hàng (VD 10%)',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::System,
                'desc' => 'notification.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bikedriver_commission',
                'setting_name' => 'Phần trăm chia cho tài xế từng đơn ( % )',
                'plain_value' => '70',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Phần trăm giá trị đơn hàng chia cho tài xế. Ví dụ: 70% cho tài xế, 30% doanh nghiệp lấy.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_driver_commission',
                'setting_name' => 'Phần trăm chia cho tài xế từng đơn hàng (%)',
                'plain_value' => '70',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Phần trăm giá trị đơn hàng chia cho tài xế. Ví dụ: 70% cho tài xế, 30% doanh nghiệp giữ lại.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_driver_base_distance',
                'setting_name' => 'Quãng đường tính giá mở cửa (km)',
                'plain_value' => '1',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Khoảng cách cơ bản tính giá mở cửa, tính theo đơn vị km.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_driver_base_fare',
                'setting_name' => 'Giá mở cửa (VNĐ)',
                'plain_value' => '20000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Giá mở cửa nếu khoảng cách dưới khoảng cách cơ bản, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_driver_distance_to_discount',
                'setting_name' => 'Quãng đường tính giá sau giá mở cửa (km)',
                'plain_value' => '5',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Khoảng cách từ km thứ n đến km thứ m để tính giá sau giá mở cửa.',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'setting_key' => 'bike_driver_rate_per_km',
                'setting_name' => 'Giá / 1 km sau km thứ n (VNĐ)',
                'plain_value' => '20000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Giá cho mỗi km sau khoảng cách cơ bản tính giá, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_driver_rate_per_km_discount',
                'setting_name' => 'Giá / 1 km sau km thứ m (VNĐ)',
                'plain_value' => '15000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::Cost,
                'desc' => 'Giá cho mỗi km sau km thứ m, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'platform_fee_C_Car',
                'setting_name' => 'Phí nền tảng C - Car / đơn hàng (VD: 5%) ',
                'plain_value' => 5,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Tính phí nền tảng dựa trên loại phương tiện.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'platform_fee_C_Ride',
                'setting_name' => 'Phí nền tảng C - Ride / đơn hàng (VD: 10%) ',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Tính phí nền tảng dựa trên loại phương tiện.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'platform_fee_C_Delivery ',
                'setting_name' => 'Phí nền tảng C - Delivery (VD: 10%)',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Tính phí nền tảng dựa trên loại phương tiện (VD: 10%).',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'platform_fee_C_Intercity',
                'setting_name' => 'Phí nền tảng C - Intercity / đơn hàng (VD: 10%) ',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Tính phí nền tảng dựa trên loại phương tiện.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'enable_platform_fee_C_multi',
                'setting_name' => 'Bật/Tắt phí nền tảng Đa điểm',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Checkbox,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Bật hoặc tắt phí nền tảng cho Đa điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'c_multi',
                'setting_name' => 'Phí cơ bản C_Multi',
                'plain_value' => 25000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Phí cơ bản ( Giá tham khảo 40.000 vnđ/ km)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'round_trip_price_c_mutli',
                'setting_name' => 'Giá khứ hồi',
                'plain_value' => 100000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Giá khứ hồi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'platform_fee_C_Multi',
                'setting_name' => 'Phí nền tảng C_Multi / đơn hàng (VD: 10%) ',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Tính phí nền tảng dựa trên loại phương tiện.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'reference_price_C_Multi',
                'setting_name' => 'Giá tham khảo',
                'plain_value' => 40000,
                'type_input' => SettingTypeInput::Price,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Giá tham khảo 40.000 vnd/người',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_commission',
                'setting_name' => 'Phần trăm chia cho tài xế từng đơn hàng (%)',
                'plain_value' => '50',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Phần trăm giá trị đơn hàng chia cho tài xế. Ví dụ: 70% cho tài xế, 30% doanh nghiệp giữ lại.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_commission',
                'setting_name' => 'Phần trăm chia cho tài xế từng đơn hàng (%)',
                'plain_value' => '60',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Phần trăm giá trị đơn hàng chia cho tài xế. Ví dụ: 70% cho tài xế, 30% doanh nghiệp giữ lại.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_commission',
                'setting_name' => 'Phần trăm chia cho tài xế từng đơn hàng (%)',
                'plain_value' => '70',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Phần trăm giá trị đơn hàng chia cho tài xế. Ví dụ: 70% cho tài xế, 30% doanh nghiệp giữ lại.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_base_distance',
                'setting_name' => 'Quãng đường tính giá mở cửa (km)',
                'plain_value' => '1',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Khoảng cách cơ bản tính giá mở cửa, tính theo đơn vị km.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_base_distance',
                'setting_name' => 'Quãng đường tính giá mở cửa (km)',
                'plain_value' => '1',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Khoảng cách cơ bản tính giá mở cửa, tính theo đơn vị km.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_base_distance',
                'setting_name' => 'Quãng đường tính giá mở cửa (km)',
                'plain_value' => '1',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Khoảng cách cơ bản tính giá mở cửa, tính theo đơn vị km.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_base_fare',
                'setting_name' => 'Giá mở cửa (VNĐ)',
                'plain_value' => '10000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Giá mở cửa nếu khoảng cách dưới khoảng cách cơ bản, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_base_fare',
                'setting_name' => 'Giá mở cửa (VNĐ)',
                'plain_value' => '15000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Giá mở cửa nếu khoảng cách dưới khoảng cách cơ bản, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_base_fare',
                'setting_name' => 'Giá mở cửa (VNĐ)',
                'plain_value' => '20000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Giá mở cửa nếu khoảng cách dưới khoảng cách cơ bản, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_distance_to_discount',
                'setting_name' => 'Quãng đường tính giá sau giá mở cửa (km)',
                'plain_value' => '5',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Khoảng cách từ km thứ n đến km thứ m để tính giá sau giá mở cửa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_distance_to_discount',
                'setting_name' => 'Quãng đường tính giá sau giá mở cửa (km)',
                'plain_value' => '4',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Khoảng cách từ km thứ n đến km thứ m để tính giá sau giá mở cửa.',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'setting_key' => 'bike_C_Delivery_distance_to_discount',
                'setting_name' => 'Quãng đường tính giá sau giá mở cửa (km)',
                'plain_value' => '2',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Khoảng cách từ km thứ n đến km thứ m để tính giá sau giá mở cửa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_rate_per_km',
                'setting_name' => 'Giá / 1 km sau km thứ n (VNĐ)',
                'plain_value' => '10000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Giá cho mỗi km sau khoảng cách cơ bản tính giá, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_rate_per_km',
                'setting_name' => 'Giá / 1 km sau km thứ n (VNĐ)',
                'plain_value' => '15000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Giá cho mỗi km sau khoảng cách cơ bản tính giá, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_rate_per_km',
                'setting_name' => 'Giá / 1 km sau km thứ n (VNĐ)',
                'plain_value' => '20000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Giá cho mỗi km sau khoảng cách cơ bản tính giá, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_rate_per_km_discount',
                'setting_name' => 'Giá / 1 km sau km thứ m (VNĐ)',
                'plain_value' => '10000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Giá cho mỗi km sau km thứ m, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_rate_per_km_discount',
                'setting_name' => 'Giá / 1 km sau km thứ m (VNĐ)',
                'plain_value' => '15000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Car,
                'desc' => 'Giá cho mỗi km sau km thứ m, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_rate_per_km_discount',
                'setting_name' => 'Giá / 1 km sau km thứ m (VNĐ)',
                'plain_value' => '20000',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Giá cho mỗi km sau km thứ m, tính bằng VNĐ.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_morning_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '09:05:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Car,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_morning_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '11:30:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Car,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_afternoon_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '17:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Car,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Car_afternoon_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '20:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Car,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_morning_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '09:05:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_morning_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '11:30:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_afternoon_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '17:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Ride_afternoon_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '20:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Ride,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_morning_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '09:05:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_morning_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '11:30:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_afternoon_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '17:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Delivery_afternoon_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '20:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Delivery,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Intercity_morning_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '09:05:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Intercity_morning_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '11:30:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Intercity_afternoon_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '17:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Intercity_afternoon_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '20:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Intercity,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Multi_morning_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '09:05:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Multi_morning_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '11:30:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Multi_afternoon_start',
                'setting_name' => 'Giờ bắt đầu',
                'plain_value' => '17:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Bắt đầu giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'setting_key' => 'bike_C_Multi_afternoon_end',
                'setting_name' => 'Giờ kết thúc',
                'plain_value' => '20:00:00',
                'type_input' => SettingTypeInput::Time,
                'group' => SettingGroup::C_Multi,
                'desc' => 'Kết thúc giờ cao điểm.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
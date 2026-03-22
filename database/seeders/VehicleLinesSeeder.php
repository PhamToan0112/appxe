<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleLinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('shipping_weight_ranges')->delete();
        DB::table('vehicle_lines')->insert([
            [
                'name' => 'Xe mini',
                'description' => 'Loại xe nhỏ gọn với chỗ ngồi cho hai người.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Limousine ',
                'description' => 'Limousine',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe sedan',
                'description' => 'Xe có chỗ ngồi cho 4-5 người, hình dáng thon dài và mui xe riêng rẽ.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe hatchback',
                'description' => 'Xe có mui sau có thể mở và chỗ ngồi cho 4-5 người.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe SUV',
                'description' => 'Xe đa dụng thể thao có chỗ ngồi cho 5-7 người và khả năng vận hành trên địa hình khó khăn.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe MPV',
                'description' => 'Xe đa dụng gia đình với chỗ ngồi cho 7-8 người và không gian rộng rãi.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe bán tải',
                'description' => 'Dòng xe tải cỡ nhỏ với cabin 4-5 chỗ và khoang sau dùng để chở hàng hoặc vận chuyển.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe coupe',
                'description' => 'Xe có dáng thể thao, thường chỉ có chỗ ngồi cho 2 người và mui xe ngắn.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Xe convertible',
                'description' => 'Xe có thể tháo rời mui trên và có chỗ ngồi cho 2-4 người.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Intercity(9 chỗ)',
                'description' => 'Xe liên tỉnh có chỗ ngồi cho 9 người',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Intercity(11 chỗ)',
                'description' => 'Xe liên tỉnh có chỗ ngồi cho 11 người',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Intercity(22 chỗ)',
                'description' => 'Xe liên tỉnh có chỗ ngồi cho 22 người',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Intercity(28 chỗ)',
                'description' => 'Xe liên tỉnh có chỗ ngồi cho 28 người',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
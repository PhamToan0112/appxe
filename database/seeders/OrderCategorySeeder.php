<?php

namespace Database\Seeders;

use App\Enums\ActiveStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            [
                'name' => 'Thực phẩm',
                'description' => 'Các sản phẩm liên quan đến thực phẩm',
                'status' => ActiveStatus::Active->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Điện tử',
                'description' => 'Các sản phẩm điện tử',
                'status' => ActiveStatus::Active->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gia dụng',
                'description' => 'Các sản phẩm gia dụng',
                'status' => ActiveStatus::Active->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Đồ vải',
                'description' => 'Quần áo và các sản phẩm từ vải',
                'status' => ActiveStatus::Active->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Khác',
                'description' => 'Các sản phẩm không thuộc các nhóm trên',
                'status' => ActiveStatus::Active->value,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

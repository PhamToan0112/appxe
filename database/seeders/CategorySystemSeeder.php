<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        DB::table('category_systems')->truncate();
        DB::table('category_systems')->insert([
            [
                'name' => 'C-Car',
                'avatar' => '/public/uploads/images/99-thuyen_hoa.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Ride',
                'avatar' => '/public/uploads/images/99-thuyen_hoa.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Intercity',
                'avatar' => '/public/uploads/images/99-thuyen_hoa.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'C-Delivery',
                'avatar' => '/public/uploads/images/99-thuyen_hoa.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

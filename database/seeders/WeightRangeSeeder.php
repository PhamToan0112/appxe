<?php

namespace Database\Seeders;

use App\Enums\DefaultStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeightRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        DB::table('shipping_weight_ranges')->delete();
        DB::table('shipping_weight_ranges')->insert([
            [
                'min_weight' => 0,
                'max_weight' => 5,
                'status' => DefaultStatus::Published,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'min_weight' => 5,
                'max_weight' => 10,
                'status' => DefaultStatus::Published,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'min_weight' => 10,
                'max_weight' => 15,
                'status' => DefaultStatus::Published,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'min_weight' => 15,
                'max_weight' => 20,
                'status' => DefaultStatus::Published,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'min_weight' => 20,
                'max_weight' => 25,
                'status' => DefaultStatus::Published,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}

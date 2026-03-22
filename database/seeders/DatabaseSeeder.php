<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        $this->call([
            SettingSeeder::class,
            PermissionSeeder::class,
            CategorySystemSeeder::class,
            WeightRangeSeeder::class,
            BankSeeder::class,
            VehicleLinesSeeder::class,
            OrderCategorySeeder::class,
        ]);
    }
}

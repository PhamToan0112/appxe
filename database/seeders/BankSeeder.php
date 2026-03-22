<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $response = Http::get('https://api.vietqr.io/v2/banks');

        if ($response->successful()) {
            $data = $response->json()['data'];

            $banks = collect($data)->map(function ($item) {
                return [
                    'name' => $item['name'],
                    'code' => $item['code']
                ];
            });

            DB::table('banks')->delete();
            foreach ($banks->chunk(50) as $chunk) {
                DB::table('banks')->insert($chunk->toArray());
            }
        } else {
            info('Failed to fetch banks from API');
        }
    }
}

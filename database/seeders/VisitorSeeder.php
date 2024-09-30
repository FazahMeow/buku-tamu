<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('visitors')->insert([
                'name' => 'Pengunjung ' . ($i + 1),
                'phone' => '08' . rand(1000000000, 9999999999),
                'email' => Str::random(10) . '@example.com',
                'company' => 'PT. ' . Str::random(5),
                'purpose' => ['Meeting', 'Interview', 'Delivery', 'Maintenance'][rand(0, 3)],
                'remarks' => 'Keterangan untuk pengunjung ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Password terenkripsi
            ],
            [
                'username' => 'admin2',
                'name' => 'Admin2',
                'password' => Hash::make('admin456'), // Password terenkripsi untuk admin 2
            ]
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_user')->insert([
            [
                'user_id'         => Str::random(15), // Generate unique user_id
                'user_full_name'  => 'Super Admin',
                'username'        => 'super.admin',
                'user_email'      => 'super.admin@bac.com',
                'user_password'   => Hash::make('aba1234567'), // Hash the password
                'user_active'     => '1', // Active
                'user_img_path'   => '/img/users/',
                'user_img_name'   => 'default.png',
                'no_telp'         => '0811393968',
                'created_by'      => 'system',
                'modified_by'     => 'system',
                'created_date'      => now(),
            ],
            // Add more user records as needed
        ]);
    }
}

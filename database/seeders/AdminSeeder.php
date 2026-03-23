<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin IndusRent',
                'email' => 'admin@indusrent.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@indusrent.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($admins as $admin) {
            if (DB::table('admins')->where('email', $admin['email'])->doesntExist()) {
                DB::table('admins')->insert($admin);
            }
        }

        $this->command->info('Đã tạo ' . count($admins) . ' admin users!');
        $this->command->info('Email: admin@indusrent.com | Password: password123');
        $this->command->info('Email: manager@indusrent.com | Password: password123');
    }
}

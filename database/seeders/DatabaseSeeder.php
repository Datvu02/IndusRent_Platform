<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Bắt đầu seed data cho IndusRent Platform...');
        $this->command->info('');

        // 1. Seed Locations (locations cần được tạo trước)
        $this->command->info('📍 Seeding Locations...');
        $this->call(LocationSeeder::class);
        $this->command->info('');

        // 2. Seed Properties (phụ thuộc vào PropertyTypes và Locations từ migration)
        $this->command->info('🏭 Seeding Properties...');
        $this->call(PropertySeeder::class);
        $this->command->info('');

        // 3. Seed News
        $this->command->info('📰 Seeding News...');
        $this->call(NewsSeeder::class);
        $this->command->info('');

        // 4. Seed Inquiries (phụ thuộc vào Properties)
        $this->command->info('💬 Seeding Inquiries...');
        $this->call(InquirySeeder::class);
        $this->command->info('');

        // 5. Seed Admins
        $this->command->info('👤 Seeding Admins...');
        $this->call(AdminSeeder::class);
        $this->command->info('');

        // 6. Seed Settings
        $this->command->info('⚙️ Seeding Settings...');
        $this->call(SettingSeeder::class);
        $this->command->info('');

        // 7. Seed Sliders
        $this->command->info('🎬 Seeding Sliders...');
        $this->call(SliderSeeder::class);
        $this->command->info('');

        // 8. Seed Default User
        $this->command->info('👥 Seeding Default User...');
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
            $this->command->info('✅ Created test user: test@example.com');
        } else {
            $this->command->info('ℹ️ Test user already exists');
        }
        $this->command->info('');

        $this->command->info('✨ Hoàn thành! Dữ liệu đã được seed thành công.');
        $this->command->info('');
        $this->command->info('📋 Thông tin đăng nhập:');
        $this->command->info('   Admin: admin@indusrent.com / password123');
        $this->command->info('   Manager: manager@indusrent.com / password123');
        $this->command->info('   User: test@example.com / password');
    }
}

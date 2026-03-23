<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('locations')->count() === 0) {
            DB::table('locations')->insert([
                'province' => 'Hà Nội',
                'district' => 'Quận Đống Đa',
                'slug' => 'ha-noi-dong-da',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
    }
};

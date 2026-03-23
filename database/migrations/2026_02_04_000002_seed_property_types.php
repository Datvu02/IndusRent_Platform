<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $types = [
            ['name' => 'Nhà xưởng cho thuê', 'slug' => 'nha-xuong-cho-thue', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kho cho thuê', 'slug' => 'kho-cho-thue', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mặt bằng cho thuê', 'slug' => 'mat-bang-cho-thue', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đất bán / Chuyển nhượng', 'slug' => 'dat-ban', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nhà xưởng bán', 'slug' => 'nha-xuong-ban', 'created_at' => now(), 'updated_at' => now()],
        ];
        foreach ($types as $t) {
            if (DB::table('property_types')->where('slug', $t['slug'])->doesntExist()) {
                DB::table('property_types')->insert($t);
            }
        }
    }

    public function down(): void
    {
        DB::table('property_types')->whereIn('slug', [
            'nha-xuong-cho-thue', 'kho-cho-thue', 'mat-bang-cho-thue', 'dat-ban', 'nha-xuong-ban'
        ])->delete();
    }
};

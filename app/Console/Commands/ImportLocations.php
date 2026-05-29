<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportLocations extends Command
{
    protected $signature = 'import:locations';
    protected $description = 'Import VN locations from local JSON';

    public function handle()
    {
        $this->info('🚀 Import from local JSON...');

        $provinces = json_decode(file_get_contents(storage_path('app/locations/provinces.json')), true);
        $districts = json_decode(file_get_contents(storage_path('app/locations/districts.json')), true);
        $wards = json_decode(file_get_contents(storage_path('app/locations/wards.json')), true);

        DB::beginTransaction();

        try {
            $rows = [];
            $count = 0;

            $districtMap = [];
            foreach ($districts as $d) {
                $districtMap[$d['code']] = $d;
            }

            $provinceMap = [];
            foreach ($provinces as $p) {
                $provinceMap[$p['code']] = $p;
            }

            foreach ($wards as $ward) {

                $district = $districtMap[$ward['parent_code']] ?? null;
                if (!$district) continue;

                $province = $provinceMap[$district['parent_code']] ?? null;
                if (!$province) continue;

                $provinceName = $province['name'];
                $districtName = $district['name'];
                $wardName = $ward['name'];

                $slug = Str::slug($provinceName . '-' . $districtName . '-' . $wardName);
                $rows[] = [
                    'province' => $provinceName,
                    'province_en' => null,
                    'province_zh' => null,

                    'district' => $districtName,
                    'district_en' => null,
                    'district_zh' => null,

                    'ward' => $wardName,
                    'ward_en' => null,
                    'ward_zh' => null,
                    
                    'slug' => $slug,

                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $count++;

                if (count($rows) >= 500) {
                    DB::table('locations')->upsert(
                        $rows,
                        ['slug'],
                        ['updated_at']    
                    );
                    $rows = [];
                    $this->info("Inserted {$count}");
                }
            }

            if (!empty($rows)) {
                    DB::table('locations')->upsert(
                        $rows,
                        ['slug'],
                        ['updated_at']    
                    );
            }

            DB::commit();

            $this->info("✅ DONE: {$count} records");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportLocations extends Command
{
    protected $signature = 'import:locations {--fresh : Truncate locations table before import}';
    protected $description = 'Import VN locations from local JSON (provinces/districts/wards)';

    public function handle()
    {
        $provincesPath = storage_path('app/locations/provinces.json');
        $districtsPath = storage_path('app/locations/districts.json');
        $wardsPath = storage_path('app/locations/wards.json');

        foreach ([$provincesPath, $districtsPath, $wardsPath] as $path) {
            if (!is_file($path)) {
                $this->error("Missing file: {$path}");
                return self::FAILURE;
            }
        }

        $this->info('Importing VN locations from local JSON...');

        $provinces = array_values(json_decode(file_get_contents($provincesPath), true) ?: []);
        $districts = array_values(json_decode(file_get_contents($districtsPath), true) ?: []);
        $wards = array_values(json_decode(file_get_contents($wardsPath), true) ?: []);

        if (empty($provinces) || empty($districts) || empty($wards)) {
            $this->error('JSON files are empty or invalid.');
            return self::FAILURE;
        }

        DB::beginTransaction();

        try {
            if ($this->option('fresh')) {
                // Keep properties that reference locations; only clear location rows we can replace.
                DB::table('locations')->delete();
                $this->warn('Cleared existing locations.');
            }

            $districtMap = [];
            foreach ($districts as $d) {
                $districtMap[$d['code']] = $d;
            }

            $provinceMap = [];
            foreach ($provinces as $p) {
                $provinceMap[$p['code']] = $p;
            }

            $rows = [];
            $count = 0;
            $skipped = 0;

            foreach ($wards as $ward) {
                $district = $districtMap[$ward['parent_code']] ?? null;
                if (!$district) {
                    $skipped++;
                    continue;
                }

                $province = $provinceMap[$district['parent_code']] ?? null;
                if (!$province) {
                    $skipped++;
                    continue;
                }

                $provinceName = $province['name'] ?? $province['name_with_type'] ?? null;
                $districtName = $district['name_with_type'] ?? $district['name'] ?? null;
                $wardName = $ward['name_with_type'] ?? $ward['name'] ?? null;

                if (!$provinceName || !$districtName || !$wardName) {
                    $skipped++;
                    continue;
                }

                $slug = Str::slug($provinceName . '-' . $districtName . '-' . $wardName . '-' . ($ward['code'] ?? $count));

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
                        ['province', 'district', 'ward', 'updated_at']
                    );
                    $rows = [];
                    $this->info("Upserted {$count}...");
                }
            }

            if (!empty($rows)) {
                DB::table('locations')->upsert(
                    $rows,
                    ['slug'],
                    ['province', 'district', 'ward', 'updated_at']
                );
            }

            DB::commit();

            $this->info("DONE: {$count} wards imported" . ($skipped ? " ({$skipped} skipped)" : ''));
            $this->info('Provinces available: ' . DB::table('locations')->distinct()->count('province'));

            return self::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}

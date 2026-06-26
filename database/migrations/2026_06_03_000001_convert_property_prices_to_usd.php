<?php

use App\Models\Property;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $rate = (float) config('currency.vnd_to_usd_rate', 25000);
        if ($rate <= 0) {
            return;
        }

        $avg = Property::query()->whereNotNull('price')->avg('price');
        if ($avg === null || (float) $avg <= 1_000_000) {
            return;
        }

        Property::query()
            ->whereNotNull('price')
            ->each(function (Property $property) use ($rate) {
                $property->update([
                    'price' => round((float) $property->price / $rate, 2),
                ]);
            });
    }

    public function down(): void
    {
        // Không hoàn ngược tự động — tỷ giá có thể thay đổi theo thời gian.
    }
};

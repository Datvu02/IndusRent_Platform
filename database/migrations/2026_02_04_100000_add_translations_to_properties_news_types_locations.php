<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Thêm cột đa ngôn ngữ (en, zh) cho content. Cột gốc (title, description...) dùng cho tiếng Việt.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_zh')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description');
            $table->text('description_zh')->nullable()->after('description_en');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_zh')->nullable()->after('title_en');
            $table->text('content_en')->nullable()->after('content');
            $table->text('content_zh')->nullable()->after('content_en');
        });

        Schema::table('property_types', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_zh')->nullable()->after('name_en');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('province_en')->nullable()->after('province');
            $table->string('province_zh')->nullable()->after('province_en');
            $table->string('district_en')->nullable()->after('district');
            $table->string('district_zh')->nullable()->after('district_en');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_zh', 'description_en', 'description_zh']);
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_zh', 'content_en', 'content_zh']);
        });
        Schema::table('property_types', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_zh']);
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['province_en', 'province_zh', 'district_en', 'district_zh']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('type', 32)->default('contact')->after('id');
            $table->string('company')->nullable()->after('name');
            $table->string('nationality')->nullable()->after('company');
            $table->string('address')->nullable()->after('nationality');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['type', 'company', 'nationality', 'address']);
        });
    }
};

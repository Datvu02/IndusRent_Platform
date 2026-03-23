<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("sliders", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("title_en")->nullable();
            $table->string("title_zh")->nullable();
            $table->text("description")->nullable();
            $table->text("description_en")->nullable();
            $table->text("description_zh")->nullable();
            $table->string("image");
            $table->string("link")->nullable();
            $table->integer("order")->default(0);
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("sliders");
    }
};

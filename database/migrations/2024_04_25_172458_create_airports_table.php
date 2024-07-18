<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('country_code');
            $table->string('region_en');
            $table->string('region_ar');
            $table->string('country_name_en');
            $table->string('country_name_ar');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->index('name_en', 'idx_name_en');
            $table->index('name_ar', 'idx_name_ar');
            $table->index('region_en', 'idx_region_en');
            $table->index('region_ar', 'idx_region_ar');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};

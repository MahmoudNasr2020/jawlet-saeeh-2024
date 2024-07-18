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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->longText('about_us_ar');
            $table->longText('about_us_en');
            $table->longText('director_word_ar');
            $table->longText('director_word_en');
            $table->longText('introduction_ar');
            $table->longText('introduction_en');
            $table->longText('mission_ar');
            $table->longText('mission_en');
            $table->longText('vision_ar');
            $table->longText('vision_en');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};

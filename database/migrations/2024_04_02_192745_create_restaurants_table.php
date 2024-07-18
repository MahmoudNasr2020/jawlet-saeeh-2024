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
        Schema::create('restaurants', function (Blueprint $table) {
             $table->id();
            $table->string('name');
            $table->text('desc');
            $table->string('price_per_day');
            $table->string('rating')->default(0);
            $table->string('service_fees');
            $table->string('location');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('main_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};

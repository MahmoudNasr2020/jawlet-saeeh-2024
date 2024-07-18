<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rental_cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('main_image');
            $table->json('images')->nullable();
            $table->string('location');
            $table->integer('count')->nullable();
            $table->double('price_per_day');
            $table->longText('description');
            $table->foreignId('rental_car_department_id');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('rental_cars');
    }
};

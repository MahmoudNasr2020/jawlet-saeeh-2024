<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rental_car_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('identity_number');
            $table->string('license_number');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('latitude');
            $table->string('longitude');
            $table->decimal('total_price', 8, 2);
            $table->enum('contract_status', [1,0])->default(0);
            $table->enum('status', [1,0])->default(0);
            $table->tinyInteger('is_viewed')->default(0);
            $table->foreignId('user_id');
            $table->foreignId('rental_car_id');
            $table->foreignId('city_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_car_reservations');
    }
};

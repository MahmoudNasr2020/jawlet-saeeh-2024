<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hotel_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hotel_id');
            $table->integer('rooms');
            $table->json('number_of_persons');
            $table->double('total_price');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->enum('status',[0,1])->default(0);
            $table->enum('is_canceled',[1,0])->default(0);
            $table->string('email');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hotel_reservations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('flight_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_airport_id');
            $table->unsignedBigInteger('to_airport_id');
            $table->enum('type',['one_way','round_trip']);
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->integer('number_of_persons');
            $table->string('class');
            $table->enum('status',[0,1])->default(0);
            $table->enum('is_canceled',[1,0])->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_airport_id')->references('id')->on('airports')->onDelete('cascade');
            $table->foreign('to_airport_id')->references('id')->on('airports')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_reservations');
    }
};

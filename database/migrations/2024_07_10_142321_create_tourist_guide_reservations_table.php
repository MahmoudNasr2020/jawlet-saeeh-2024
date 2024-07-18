<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tourist_guide_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('from_date');
            $table->date('to_date');
            $table->foreignId('tourist_guide_id')->constrained()->onDelete('cascade');
            $table->foreignId('tourist_guide_place_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_canceled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourist_guide_reservations');
    }
};

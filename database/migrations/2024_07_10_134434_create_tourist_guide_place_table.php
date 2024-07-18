<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tourist_guide_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourist_guide_id')->constrained()->onDelete('cascade');
            $table->foreignId('tourist_guide_place_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_guide_place');
    }
};

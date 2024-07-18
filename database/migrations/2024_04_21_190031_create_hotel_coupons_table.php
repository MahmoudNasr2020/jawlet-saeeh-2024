<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hotel_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('type',['percentage','price']);
            $table->integer('discount_percentage')->nullable();
            $table->integer('maximum_discount')->nullable();
            $table->integer('price')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('usage_count');
            $table->integer('usage_limit')->default(1);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hotel_coupons');
    }
};

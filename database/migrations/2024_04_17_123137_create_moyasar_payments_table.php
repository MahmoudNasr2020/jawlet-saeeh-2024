<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('moyasar_payments', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['test','live'])->default('test');
            $table->text('test_publishable_key');
            $table->text('test_secret_key');
            $table->text('live_publishable_key');
            $table->text('live_secret_key');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('moyasar_payments');
    }
};

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
        Schema::create('restaurant_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('store_name_ar');
            $table->string('store_name_en');
            $table->integer('branch_count');
            $table->string('twitter_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('google_maps_link')->nullable();
            $table->string('company_name_en');
            $table->string('email');
            $table->string('bank_name');
            $table->string('iban');
            $table->string('manager_phone');
            $table->string('operation_manager_phone');
            $table->string('marketing_phone');
            $table->string('commercial_registration');
            $table->string('tax_certificate');
            $table->string('bank_account');
            $table->string('national_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_registrations');
    }
};

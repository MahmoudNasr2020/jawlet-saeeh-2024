<?php

namespace Database\Seeders;

use App\Models\MoyasarPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoyasarPaymentSeeder extends Seeder
{

    public function run(): void
    {
        MoyasarPayment::create([
            'status' => 'test',
            'test_publishable_key' => 'pk_test_UU4xnSS2yi9pGKxman9D36yWtjN57gCqH31XTG14',
            'test_secret_key' => 'sk_test_GRBEVi2Wi8W8uWoYhC85DhQwTVSEfmWxsEo6q9iP',
            'live_publishable_key' => 'pk_live_A1v69K12kTedosiE86bfoFxhh3H8Y6EmSdgfUmzY',
            'live_secret_key' => 'sk_live_r8o1eSVwMr4rYoaWCktWkLyicCeURxpBpCUVH95R',
        ]);

    }
}

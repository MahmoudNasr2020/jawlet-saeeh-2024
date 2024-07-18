<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        Admin::truncate();
        $admin = Admin::updateOrCreate([
            'name' => 'Mahmoud Nasr',
            'email' => 'test@test.com',
            'password' => bcrypt('123456'),
        ]);
    }
}

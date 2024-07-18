<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_name_en' => 'jawlat saeeh',
            'site_name_ar' => 'jawlat saeeh',
            'email' => 'test@test.com',
            'phone' => '123456789',
            'address_ar' => 'asdasd',
            'address_en' => 'اي حاجة',
            'map'        => 's',
            'logo'       => 's',
            'icon'       => 's',
        ]);
    }
}

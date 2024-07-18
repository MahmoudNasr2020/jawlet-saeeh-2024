<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'about_us_ar'      => 'test',
            'about_us_en'      => 'اي حاجة',
            'director_word_ar' => 'test',
            'director_word_en' => 'اي حاجة',
            'introduction_ar'  => 'test',
            'introduction_en'  => 'اي حاجة',
            'mission_ar'       => 'test',
            'mission_en'       => 'اي حاجة',
            'vision_ar'        => 'test',
            'vision_en'        => 'اي حاجة',
        ]);
    }
}

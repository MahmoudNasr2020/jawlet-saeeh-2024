<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_us_ar',
        'about_us_en',
        'director_word_ar',
        'director_word_en',
        'introduction_ar',
        'introduction_en',
        'mission_ar',
        'mission_en',
        'vision_ar',
        'vision_en',
    ];

}

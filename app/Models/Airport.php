<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    public $fillable = ['name_en', 'name_ar', 'country_code', 'region_ar','region_en', 'latitude', 'longitude','country_name_en', 'country_name_ar'];
}

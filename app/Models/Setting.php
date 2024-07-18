<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['site_name_ar','site_name_en', 'email', 'phone' ,'phone_2','phone_3', 'address', 'map',
        'website', 'facebook', 'youtube', 'x', 'instagram', 'linkedin','tiktok','snapchat',
'logo', 'icon'];

    public function getLogoAttribute($value)
    {
        return asset('images/' . $value);
    }

    public function getIconAttribute($value)
    {
        return asset('images/' . $value);
    }

}

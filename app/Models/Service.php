<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'text_ar',
        'text_en',
        'image'
    ];

    public function getImageAttribute($value)
    {
        return asset('images/' . $value);
    }
}

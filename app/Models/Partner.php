<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = [
        'name',
        'image'
    ];

    public function getImageAttribute($value)
    {
        return asset('images/' . $value);
    }
}

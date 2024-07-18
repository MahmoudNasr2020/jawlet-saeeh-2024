<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['type','price_per_day','count','hotel_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id');
    }
}

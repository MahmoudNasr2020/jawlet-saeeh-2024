<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalTrip extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'location',
        'price_per_person',
        'main_image',
        'images',
        'start_date',
    ];

    public function getMainImageAttribute($value)
    {
        return asset('images/' . $value);
    }

    public function getImagesAttribute($value)
    {
        if ($value != '') {
            $imagePaths = json_decode($value, true);
            $fullPaths = [];

            foreach ($imagePaths as $imagePath) {
                $fullPaths[] = asset('images/' . $imagePath);
            }

            return $fullPaths;
        }

        return [];
    }

    public function getDaysCountAttribute()
    {
        if ($this->start_date && $this->end_date) {
            $start_date = Carbon::parse($this->start_date);
            $end_date = Carbon::parse($this->end_date);
            return $end_date->diffInDays($start_date) + 1;
        }

        return 0;
    }
}

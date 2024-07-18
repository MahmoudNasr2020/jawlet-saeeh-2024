<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristGuideReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'from_date',
        'to_date',
        'tourist_guide_id',
        'tourist_guide_place_id',
        'is_active',
        'is_canceled'
    ];

    public function guide()
    {
        return $this->belongsTo(TouristGuide::class, 'tourist_guide_id');
    }

    public function place()
    {
        return $this->belongsTo(TouristGuidePlace::class, 'tourist_guide_place_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilgrimageTripReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'adults_count',
        'children_count',
        'total_price',
        'user_id',
        'pilgrimage_trip_id',
        'status',
        'is_canceled',
    ];

    // علاقة مع جدول User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع جدول PilgrimageTrip
    public function pilgrimageTrip()
    {
        return $this->belongsTo(PilgrimageTrip::class);
    }
}

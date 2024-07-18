<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalTripReservation extends Model
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
        'internal_trip_id',
        'status',
        'is_canceled',
    ];

    // علاقة مع جدول User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع جدول InternalTrip
    public function internalTrip()
    {
        return $this->belongsTo(InternalTrip::class);
    }
}

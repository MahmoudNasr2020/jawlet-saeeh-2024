<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalTripReservation extends Model
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
        'external_trip_id',
        'is_active',
        'is_canceled',
    ];

    // علاقة مع جدول User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع جدول ExternalTrip
    public function externalTrip()
    {
        return $this->belongsTo(ExternalTrip::class);
    }

    // خاصية لحساب عدد أيام الرحلة
    /*protected $appends = ['days_count'];

    public function getDaysCountAttribute()
    {
        $trip = $this->externalTrip;
        if ($trip->start_date && $trip->end_date) {
            $start_date = \Carbon\Carbon::parse($trip->start_date);
            $end_date = \Carbon\Carbon::parse($trip->end_date);
            return $end_date->diffInDays($start_date) + 1; // تشمل يوم البداية والنهاية
        }

        return 0;
    }*/
}

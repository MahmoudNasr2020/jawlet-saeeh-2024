<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightReservation extends Model
{
    use HasFactory;
    protected $fillable = ['type','from_airport_id','to_airport_id','user_id',
        'start_datetime', 'end_datetime','number_of_persons','class','status', 'is_canceled'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function fromAirport()
    {
        return $this->belongsTo(Airport::class,'from_airport_id');
    }

    public function toAirport()
    {
        return $this->belongsTo(Airport::class,'to_airport_id');
    }
}

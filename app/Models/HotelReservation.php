<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'hotel_id', 'rooms', 'total_price',
        'start_datetime', 'end_datetime', 'status', 'is_canceled', 'email','number_of_persons'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id');
    }

    /*protected $casts = [
        'rooms' => 'array',
    ];*/

    public function getRoom()
    {
        //$roomIds = json_decode($this->rooms);
        return Room::where('id', $this->rooms)->first();
    }

    public function getPersons()
    {
        return json_decode($this->number_of_persons);
      //  return Room::where('id', $this->rooms)->first();
    }

}

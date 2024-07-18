<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantReservation extends Model
{
    use HasFactory;

      protected $fillable = [
        'booking_date',
        'adults',
        'children',
        'email',
        'status',
        'user_id',
        'restaurant_id',
        'total_price',
        'phone'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}

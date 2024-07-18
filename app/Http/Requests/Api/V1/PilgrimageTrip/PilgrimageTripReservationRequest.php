<?php

namespace App\Http\Requests\Api\V1\PilgrimageTrip;

use Illuminate\Foundation\Http\FormRequest;

class PilgrimageTripReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'adults_count' => 'required|integer|min:1',
            'children_count' => 'required|integer|min:0',
            'pilgrimage_trip_id' => 'required|exists:pilgrimage_trips,id',
        ];
    }
}

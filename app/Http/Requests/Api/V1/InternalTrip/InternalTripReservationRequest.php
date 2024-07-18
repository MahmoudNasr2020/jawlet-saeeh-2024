<?php

namespace App\Http\Requests\Api\V1\InternalTrip;

use Illuminate\Foundation\Http\FormRequest;

class InternalTripReservationRequest extends FormRequest
{

    public function authorize(): bool
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
            'internal_trip_id' => 'required|exists:internal_trips,id',
        ];
    }
}

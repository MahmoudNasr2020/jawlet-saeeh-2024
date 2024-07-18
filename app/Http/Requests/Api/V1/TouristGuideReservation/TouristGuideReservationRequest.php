<?php

namespace App\Http\Requests\Api\V1\TouristGuideReservation;

use Illuminate\Foundation\Http\FormRequest;

class TouristGuideReservationRequest extends FormRequest
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
            'from_date' => 'required|date|after:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'tourist_guide_id' => 'required|exists:tourist_guides,id',
            'tourist_guide_place_id' => 'required|exists:tourist_guide_places,id',
        ];
    }
}

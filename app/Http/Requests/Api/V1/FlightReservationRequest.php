<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class FlightReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'from_airport_id' => 'required|integer|exists:airports,id',
            'to_airport_id' => 'required|integer|exists:airports,id',
            'start_datetime' => 'required|date|after:today',
            'end_datetime' => 'required_if:type,round_trip|date|after_or_equal:start_datetime',
            'number_of_persons' => 'required|integer|min:1',
            'class' => 'required|string'
            ];
      }
}

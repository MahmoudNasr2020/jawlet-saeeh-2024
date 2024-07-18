<?php

namespace App\Http\Requests\Api\V1\ExternalTrip;

use Illuminate\Foundation\Http\FormRequest;

class ExternalTripReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'external_trip_id' => 'required|exists:external_trips,id',
        ];
    }
}

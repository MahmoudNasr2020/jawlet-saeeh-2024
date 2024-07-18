<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class HotelReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hotel_id' => 'required|exists:hotels,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'email' => 'required|email',
            //'number_of_persons' => 'required|json|regex:/{"adults"\s*:\s*\d+,\s*"children"\s*:\s*\d+}/',
            'room' => 'required|exists:rooms,id',
            'adults' => 'required|numeric',
            'children' => 'required|numeric',
            //'card_customer_name' => 'required|string|max:255',
            /*'card_number' => 'required|numeric|digits:16',
            'card_cvc' => 'required|numeric|digits:3',
            'card_month' => 'required|numeric',
            'card_year' => 'required|numeric|digits:4|min:' . date('Y'),*/
        ];
    }

}

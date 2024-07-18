<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentalCarReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'identity_number' => 'required',
            'license_number' => 'required',
            'start_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_date' => 'required|date|after:start_date',
            'end_time' => 'required',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            //'total_price' => 'required|numeric',
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'rental_car_id' => [
                'required',
                Rule::exists('rental_cars', 'id'),
            ],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id'),
            ],
        ];
    }
}

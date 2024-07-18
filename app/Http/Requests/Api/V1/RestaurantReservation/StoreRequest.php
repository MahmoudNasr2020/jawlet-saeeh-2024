<?php

namespace App\Http\Requests\Api\V1\RestaurantReservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_date'  => 'required|date|after_or_equal:today|date_format:Y-m-d H:i:s',
            'adults'        => 'required|numeric',
            'children'      => 'required|numeric',
            'email'         => 'required|email',
            'restaurant_id' => 'required|exists:restaurants,id',
            'phone'         => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            //'user_id' => 'required|exists:users,id',
        ];
    }
}

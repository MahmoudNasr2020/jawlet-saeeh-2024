<?php

namespace App\Http\Requests\Api\V1\RestaurantReservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'booking_date'  => 'nullable|date|after_or_equal:today',
            'adults'        => 'required|numeric',
            'children'      => 'required|numeric',
            'email'         => 'required|email',
        ];
    }
}

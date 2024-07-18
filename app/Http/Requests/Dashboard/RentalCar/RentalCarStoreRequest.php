<?php

namespace App\Http\Requests\Dashboard\RentalCar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentalCarStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rental_car_department_id' => 'required|not_in:0',
            'price_per_day' => 'required|numeric',
            'location' => 'required|string',
           // 'count' => 'required|numeric',
            'description' => 'required|string',
        ];
    }
}

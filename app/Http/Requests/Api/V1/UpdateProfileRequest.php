<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.auth()->guard('api')->user()->id],
            'phone' => ['required', 'regex:/^\+?[0-9]\d{0,14}$/','unique:users,phone,'.auth()->guard('api')->user()->id],
            'password' => ['nullable', 'string', 'min:8'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png']
        ];
    }
}

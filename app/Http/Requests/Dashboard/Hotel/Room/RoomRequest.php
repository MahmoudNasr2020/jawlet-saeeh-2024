<?php

namespace App\Http\Requests\Dashboard\Hotel\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'count' => 'required|numeric',
            'price_per_day' => 'required|numeric',
            'hotel_id' => 'required|exists:hotels,id'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'حقل نوع الغرفة مطلوب.',
            'type.string' => 'حقل نوع الغرفة يجب أن يكون نصاً.',
            'type.max' => 'حقل نوع الغرفة يجب ألا يتجاوز 255 حرفاً.',

            'count.required' => 'حقل عدد الغرف مطلوب.',
            'count.numeric' => 'حقل عدد الغرف يجب أن يكون رقماً.',

            'price_per_day.required' => 'حقل سعر الغرفة في الليلة مطلوب.',
            'price_per_day.numeric' => 'حقل سعر الغرفة في الليلة يجب أن يكون رقماً.',

            'hotel_id.required' => 'حقل معرف الفندق مطلوب.',
            'hotel_id.exists' => 'الفندق المحدد غير موجود.',
        ];
    }

}

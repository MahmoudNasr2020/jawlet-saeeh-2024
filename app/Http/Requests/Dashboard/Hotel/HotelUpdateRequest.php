<?php

namespace App\Http\Requests\Dashboard\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price_per_day' => 'required|numeric',
            'location' => 'required|string',
            'latitude' =>'required|string',
            'longitude' =>'required|string',
            'description' => 'required|string',
            'kt_docs_repeater_basic' => 'nullable|array',
            'kt_docs_repeater_basic.*.public_utility_name' => 'required|string',
            // هنا نفترض أن كل عنصر جديد سيحتوي على مفتاح 'new' مع قيمة true
            'kt_docs_repeater_basic.*.public_utility_image' => 'required_if:kt_docs_repeater_basic.*.new,true|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'image.image' => 'يجب أن تكون الصورة ملفًا من نوع صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بإحدى الصيغ التالية: jpeg, png, jpg, gif, svg.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2048 كيلوبايت.',
            'price_per_day.required' => 'حقل سعر الليلة مطلوب.',
            'location.required' => 'حقل الموقع مطلوب.',
            'latitude.required' => 'حقل خط العرض مطلوب.',
            'longitude.required' => 'حقل خط الطول مطلوب.',
            'description.required' => 'حقل الوصف مطلوب.',
            'kt_docs_repeater_basic.*.public_utility_name.required' => 'اسم المرفق العام مطلوب.',
            'kt_docs_repeater_basic.*.public_utility_image.required_if' => 'صورة المرفق العام مطلوبة لكل عنصر جديد.',
            'kt_docs_repeater_basic.*.public_utility_image.image' => 'يجب أن تكون صورة المرفق العام ملفًا من نوع صورة.',
            'kt_docs_repeater_basic.*.public_utility_image.mimes' => 'يجب أن تكون صورة المرفق العام بإحدى الصيغ التالية: jpeg, png, jpg, gif, svg.',
            'kt_docs_repeater_basic.*.public_utility_image.max' => 'يجب ألا يتجاوز حجم صورة المرفق العام 2048 كيلوبايت.',
        ];
    }

}

<?php

namespace App\Http\Requests\Dashboard\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
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
            'price_per_day' => 'required|numeric',
            'service_fees' => 'required|numeric',
            'location' => 'required|string',
            'latitude' =>'required|string',
            'longitude' =>'required|string',
            'description' => 'required|string',
            'kt_docs_repeater_basic' => 'nullable|array',
            'kt_docs_repeater_basic.*.public_utility_name' => 'required_with:kt_docs_repeater_basic|string',
            'kt_docs_repeater_basic.*.public_utility_image' => 'required_with:kt_docs_repeater_basic|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'image.required' => 'حقل الصورة مطلوب.',
            'image.image' => 'يجب أن تكون الصورة ملفًا من نوع صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بإحدى الصيغ التالية: jpeg, png, jpg, gif, svg.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2048 كيلوبايت.',
            'price_per_day.required' => 'حقل سعر الليلة مطلوب.',
            'service_fees.required' => 'حقل رسوم الخدمة مطلوب.',
            'service_fees.numeric' => 'حقل رسوم الخدمة يجب ان يكون رقمي.',
            'location.required' => 'حقل الموقع مطلوب.',
            'latitude.required' => 'حقل خط العرض مطلوب.',
            'longitude.required' => 'حقل خط الطول مطلوب.',
            'description.required' => 'حقل الوصف مطلوب.',
            'kt_docs_repeater_basic.*.public_utility_name.required_with' => 'اسم المرفق العام مطلوب عند تقديم المرافق العامة.',
            'kt_docs_repeater_basic.*.public_utility_image.required_with' => 'صورة المرفق العام مطلوبة عند تقديم المرافق العامة.',
            'kt_docs_repeater_basic.*.public_utility_image.image' => 'يجب أن تكون صورة المرفق العام ملفًا من نوع صورة.',
            'kt_docs_repeater_basic.*.public_utility_image.mimes' => 'يجب أن تكون صورة المرفق العام بإحدى الصيغ التالية: jpeg, png, jpg, gif, svg.',
            'kt_docs_repeater_basic.*.public_utility_image.max' => 'يجب ألا يتجاوز حجم صورة المرفق العام 2048 كيلوبايت.',
        ];
    }

}

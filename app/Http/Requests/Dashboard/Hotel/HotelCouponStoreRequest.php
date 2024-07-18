<?php

namespace App\Http\Requests\Dashboard\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelCouponStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:percentage,price',
            'discount_percentage' => 'required_if:type,percentage|nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric',
            'price' => 'required_if:type,price|nullable|numeric',
            'expiry_date' => 'nullable|date|after:today',
            'usage_limit' => 'nullable|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'يجب أن يكون حقل الكمية عدد صحيح.',
            'quantity.min' => 'يجب أن يكون حقل الكمية على الأقل 1.',
            'type.required' => 'حقل نوع الكوبون مطلوب.',
            'type.in' => 'القيم المقبولة لنوع الكوبون هي نسبة مئوية أو سعر.',
            'discount_percentage.required_if' => 'حقل نسبة الخصم مطلوب عند اختيار نوع الكوبون نسبة مئوية.',
            'discount_percentage.numeric' => 'يجب أن يكون حقل نسبة الخصم عدد.',
            'discount_percentage.min' => 'لا يمكن أن تكون نسبة الخصم أقل من 0.',
            'maximum_discount.numeric' => 'يجب أن يكون حقل أعلى سعر عدد.',
            'price.required_if' => 'حقل سعر الكوبون مطلوب عند اختيار نوع الكوبون سعر.',
            'price.numeric' => 'يجب أن يكون حقل سعر الكوبون عدد.',
            'expiry_date.date' => 'يجب أن يكون تاريخ الانتهاء تاريخ صالح.',
            'expiry_date.after' => 'يجب أن يكون تاريخ الانتهاء بعد اليوم.',
            'usage_limit.integer' => 'يجب أن يكون حقل عدد مرات الاستخدام عدد صحيح.',
            'usage_limit.min' => 'يجب أن يكون حقل عدد مرات الاستخدام على الأقل 1.',
        ];
    }
}

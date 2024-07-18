<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\RestaurantRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RestaurantRegistrationController extends Controller
{
    use ImageTrait;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name_ar' => 'required|string',
            'store_name_en' => 'required|string',
            'branch_count' => 'required|integer',
            'twitter_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'google_maps_link' => 'nullable|url',
            'company_name_en' => 'required|string',
            'email' => 'required|email',
            'bank_name' => 'required|string',
            'iban' => 'required|string',
            'manager_phone' => 'required|string',
            'operation_manager_phone' => 'required|string',
            'marketing_phone' => 'required|string',
            'commercial_registration' => 'required|file|max:2048',
            'tax_certificate' => 'required|file|max:2048',
            'bank_account' => 'required|file|max:2048',
            'national_address' => 'required|file|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $restaurant = new RestaurantRegistration();
        $restaurant->store_name_ar = $request->store_name_ar;
        $restaurant->store_name_en = $request->store_name_en;
        $restaurant->branch_count = $request->branch_count;
        $restaurant->twitter_link = $request->twitter_link;
        $restaurant->facebook_link = $request->facebook_link;
        $restaurant->google_maps_link = $request->google_maps_link;
        $restaurant->company_name_en = $request->company_name_en;
        $restaurant->email = $request->email;
        $restaurant->bank_name = $request->bank_name;
        $restaurant->iban = $request->iban;
        $restaurant->manager_phone = $request->manager_phone;
        $restaurant->operation_manager_phone = $request->operation_manager_phone;
        $restaurant->marketing_phone = $request->marketing_phone;

        // Handling file uploads
        if ($request->hasFile('commercial_registration')) {
           // $restaurant->commercial_registration = $request->file('commercial_registration')->store('documents');
            $restaurant->commercial_registration = $this->imageUpload('restaurantRegistration',$request->file('commercial_registration'));
        }
        if ($request->hasFile('tax_certificate')) {
           // $restaurant->tax_certificate = $request->file('tax_certificate')->store('documents');
            $restaurant->tax_certificate = $this->imageUpload('restaurantRegistration',$request->file('tax_certificate'));
        }

        if ($request->hasFile('bank_account')) {
            //$restaurant->bank_account = $request->file('bank_account')->store('documents');
            $restaurant->bank_account = $this->imageUpload('restaurantRegistration',$request->file('bank_account'));
        }

        if ($request->hasFile('national_address')) {
           // $restaurant->national_address = $request->file('national_address')->store('documents');
            $restaurant->national_address = $this->imageUpload('restaurantRegistration',$request->file('national_address'));
        }

        $restaurant->save();

        Alert::success('Success', 'تم التسجيل بنجاح');

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\About;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SettingController extends Controller
{
    use ImageTrait;
    public function index()
    {
        $setting = Setting::orderBy('id','desc')->first();
        return view('dashboard.pages.site.settings.index', compact('setting'));
    }


    // تحديث القسم في قاعدة البيانات
     public function update(Request $request, $id)
    {
        $request->validate([
            'site_name_ar' => 'required|string',
            'site_name_en' => 'required|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
            'phone_2' => 'nullable|string',
            'phone_3' => 'nullable|string',
            'address_ar' => 'required|string',
            'address_en' => 'required|string',
            'map' => 'required|string',
            'website' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'x' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'snapchat' => 'nullable|string',
            'logo' => 'nullable|image',
            'icon' => 'nullable|image',
        ]);

        $setting = Setting::findOrFail($id);

        $logo = $setting->getRawOriginal('logo');
        $icon = $setting->getRawOriginal('icon');

        if ($request->hasFile('logo')) {

            $this->deleteImage($setting->getRawOriginal('logo'));
            $logo = $this->imageUpload('settings',$request->logo);
        }

        if ($request->hasFile('icon')) {

            $this->deleteImage($setting->getRawOriginal('icon'));
            $icon = $this->imageUpload('settings',$request->icon);

        }
         Setting::orderBy('id','desc')->update([
            'site_name_ar'=> $request->site_name_ar,
            'site_name_en'=> $request->site_name_en,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'phone_2'=> $request->phone_2,
            'phone_3'=> $request->phone_3,
            'address_ar'=> $request->address_ar,
            'address_en'=> $request->address_en,
            'map'=> $request->map,
            'website'=> $request->website,
            'facebook'=> $request->facebook,
            'youtube'=> $request->youtube,
            'x'=> $request->x,
             'tiktok'=> $request->tiktok,
            'snapchat'=> $request->snapchat,
            'instagram'=> $request->instagram,
            'linkedin'=> $request->linkedin,
            'logo'=> $logo,
            'icon'=> $icon,
        ]);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }
}

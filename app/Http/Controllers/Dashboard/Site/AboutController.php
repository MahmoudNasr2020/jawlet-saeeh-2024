<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Service;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::orderBy('id','desc')->first();
        return view('dashboard.pages.site.about.index', compact('about'));
    }


    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'about_us_ar' => 'required|string',
            'about_us_en' => 'required|string',
            'director_word_ar' => 'required|string',
            'director_word_en' => 'required|string',
            'introduction_ar' => 'required|string',
            'introduction_en' => 'required|string',
            'mission_ar' => 'required|string',
            'mission_en' => 'required|string',
            'vision_ar' => 'required|string',
            'vision_en' => 'required|string',
        ]);

        $about = About::orderBy('id','desc')->update([
            'about_us_ar'=> $request->about_us_ar,
            'about_us_en'=> $request->about_us_en,
            'director_word_ar'=> $request->director_word_ar,
            'director_word_en'=> $request->director_word_en,
            'introduction_ar'=> $request->introduction_ar,
            'introduction_en'=> $request->introduction_en,
            'mission_ar'=> $request->mission_ar,
            'mission_en'=> $request->mission_en,
            'vision_ar'=> $request->vision_ar,
            'vision_en'=> $request->vision_en,
        ]);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

}

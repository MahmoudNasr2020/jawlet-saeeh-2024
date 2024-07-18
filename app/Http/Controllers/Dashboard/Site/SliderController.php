<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\RentalCarDepartments;
use App\Models\Slider;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{
    use ImageTrait;
    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $sliders = Slider::where('text', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
        } else {
            $sliders = Slider::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.site.sliders.index', compact('sliders'));
    }


    public function create()
    {
        return view('dashboard.pages.site.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text_ar' => 'required|string',
            'text_en' => 'required|string',
            'image' => 'required|image',
        ]);


        $image = $this->imageUpload('sliders',$request->image);

         Slider::create([
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'image' => $image,
        ]);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.sliders.index');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('dashboard.pages.site.sliders.edit', compact('slider'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'text_ar' => 'required|string',
            'text_en' => 'required|string',
            'image' => 'image',
        ]);

        $slider = Slider::findOrFail($id);


        if ($request->hasFile('image')) {

            $this->deleteImage($slider->getRawOriginal('image'));
            $image = $this->imageUpload('sliders',$request->image);
            $slider->image = $image;
        }

        $slider->text_ar = $request->text_ar;
        $slider->text_en = $request->text_en;
        $slider->save();

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $this->deleteImage($slider->getRawOriginal('image'));
        $slider->delete();
        return 'done';
    }
}

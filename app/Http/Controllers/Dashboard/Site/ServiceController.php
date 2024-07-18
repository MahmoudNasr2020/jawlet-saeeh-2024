<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceController extends Controller
{
    use ImageTrait;
    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $services = Service::where('text', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
        } else {
            $services = Service::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.site.services.index', compact('services'));
    }


    public function create()
    {
        return view('dashboard.pages.site.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'text_ar' => 'required|string',
            'text_en' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);


        $image = $this->imageUpload('services',$request->image);

        Service::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'image' => $image,
        ]);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.services.index');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('dashboard.pages.site.services.edit', compact('service'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'text_ar' => 'required|string',
            'text_en' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        $service = Service::findOrFail($id);


        if ($request->hasFile('image')) {

            $this->deleteImage($service->getRawOriginal('image'));
            $image = $this->imageUpload('services',$request->image);
            $service->image = $image;
        }

        $service->name_ar = $request->name_ar;
        $service->name_en = $request->name_en;
        $service->text_ar = $request->text_ar;
        $service->text_en = $request->text_en;
        $service->save();

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $this->deleteImage($service->getRawOriginal('image'));
        $service->delete();
        return 'done';
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\Partner;
use App\Models\Slider;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PartnerController extends Controller
{
    use ImageTrait;

    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $partners = Partner::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
        }
        else
        {
            $partners = Partner::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.site.partners.index', compact('partners'));
    }


    public function create()
    {
        return view('dashboard.pages.site.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);


        $image = $this->imageUpload('partners',$request->image);

        Partner::create([
            'name' => $request->name,
            'image' => $image,
        ]);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.partners.index');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('dashboard.pages.site.partners.edit', compact('partner'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        $partner = Partner::findOrFail($id);


        if ($request->hasFile('image')) {

            $this->deleteImage($partner->getRawOriginal('image'));
            $image = $this->imageUpload('partners',$request->image);
            $partner->image = $image;
        }

        $partner->name = $request->name;
        $partner->save();

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $this->deleteImage($partner->getRawOriginal('image'));
        $partner->delete();
        return 'done';
    }
}

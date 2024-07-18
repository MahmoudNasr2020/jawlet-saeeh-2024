<?php

namespace App\Http\Controllers\Dashboard\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\City;
use App\Models\RentalCarDepartments; // استيراد موديل RentalCarDepartments
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RentalCarCitiesController extends Controller
{
    use ImageTrait;
    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $cities = City::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
        }
        else {
            $cities = City::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.rental_car.cities.index', compact('cities'));
    }


    public function create()
    {
        return view('dashboard.pages.rental_car.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        //$image = $this->imageUpload('car_departments',$request->image);

        City::create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.rental-car-cities.index');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('dashboard.pages.rental_car.cities.edit', compact('city'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rental_car_departments,name,'.$id,
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $city = City::findOrFail($id);

        $city->name = $request->name;
        $city->save();

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return 'done';
    }
}

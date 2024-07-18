<?php

namespace App\Http\Controllers\Dashboard\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\RentalCarDepartments; // استيراد موديل RentalCarDepartments
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RentalCarDepartmentController extends Controller
{
    use ImageTrait;
    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $departments = RentalCarDepartments::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
        } else {
            $departments = RentalCarDepartments::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.rental_car.rental_car_departments.index', compact('departments'));
    }


    public function create()
    {
        return view('dashboard.pages.rental_car.rental_car_departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rental_car_departments,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $image = $this->imageUpload('car_departments',$request->image);

        RentalCarDepartments::create([
            'name' => $request->name,
            'image' => $image,
        ]);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.rental-car-departments.index');
    }

    public function edit($id)
    {
        $department = RentalCarDepartments::findOrFail($id);
        return view('dashboard.pages.rental_car.rental_car_departments.edit', compact('department'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rental_car_departments,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $department = RentalCarDepartments::findOrFail($id);


        if ($request->hasFile('image')) {

            $this->deleteImage($department->getRawOriginal('image'));
            $image = $this->imageUpload('car_departments',$request->image);
            $department->image = $image;
        }

        $department->name = $request->name;
        $department->save();

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $department = RentalCarDepartments::findOrFail($id);
        $this->deleteImage($department->getRawOriginal('image'));
        $department->rentalCars()->delete();
        $department->delete();
        return 'done';
    }
}

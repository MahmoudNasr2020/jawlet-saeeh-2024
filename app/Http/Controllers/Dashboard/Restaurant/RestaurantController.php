<?php

namespace App\Http\Controllers\Dashboard\Restaurant;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Trait\ImageTrait;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Dashboard\Restaurant\StoreRequest;
use App\Http\Requests\Dashboard\Restaurant\UpdateRequest;

class RestaurantController extends Controller
{
    use ImageTrait;


    public function index(Request $request)
    {
        $restaurants = Restaurant::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.pages.restaurant.index', compact('restaurants'));
    }

    public function create()
    {
        return view('dashboard.pages.restaurant.create');
    }


    public function store(StoreRequest $request)
    {
        $restaurant = Restaurant::create($request->validated());
        foreach ($request->image as $image) {
            $restaurant->addMedia($image)->toMediaCollection();
        }

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.restaurants.index');
    }

    public function show(string $id)
    {
        //
    }


    public function edit(Restaurant $restaurant)
    {
        return view('dashboard.pages.restaurant.edit', compact('restaurant'));
    }


    public function update(UpdateRequest $request, Restaurant $restaurant)
    {
        $restaurant->update($request->validated());

        Alert::success('Success', 'تمت التعديل  بنجاح');
        return redirect()->route('dashboard.restaurants.index');
    }


    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return 'done';
    }
}

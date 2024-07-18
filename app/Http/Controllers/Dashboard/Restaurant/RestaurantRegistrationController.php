<?php

namespace App\Http\Controllers\Dashboard\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\RestaurantRegistration;
use Illuminate\Http\Request;

class RestaurantRegistrationController extends Controller
{
    use ImageTrait;
    public function index()
    {
        $search = request()->query('search', '');

        $registrations = RestaurantRegistration::where('store_name_ar', 'LIKE', "%{$search}%")
            ->orWhere('store_name_en', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        $registrations->appends(['search' => $search]);

        return view('dashboard.pages.restaurant.registrations.index', compact('registrations', 'search'));
    }

    public function show($id)
    {
        $registration = RestaurantRegistration::findOrFail($id);
        return view('dashboard.pages.restaurant.registrations.show', compact('registration'));
    }

    public function destroy($id)
    {
        $registration = RestaurantRegistration::findOrFail($id);

        $this->deleteImage($registration->commercial_registration);
        $this->deleteImage($registration->tax_certificate);
        $this->deleteImage($registration->bank_account);
        $this->deleteImage($registration->national_address);

        $registration->delete();

        return 'done';
    }
}
